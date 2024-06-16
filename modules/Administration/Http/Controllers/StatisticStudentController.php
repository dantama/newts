<?php

namespace Modules\Administration\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentLevel;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;


class StatisticStudentController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        $all_count_student = ManagementRegency::with(['studentLevels' => function($studentlevel){
                        return $studentlevel->select('student_id', \DB::raw('MAX(level_id) as level_id, count(*) as student_count'))
                        ->groupBy('student_id');
                    }])->has('students')->withCount('students')->orderBy('students_count','desc')->get()->map(function($mgmt){
                        return [
                           'name' => $mgmt->name,
                           'pimwil_code' => $mgmt->management->pimwil_code,
                           'full_name' => $mgmt->fullName,
                           'studentlevels' => $mgmt->studentLevels->groupBy('detail.name')->map(function($studentlevel){
                                return $studentlevel->count();
                            })->toArray()
                        ];
                    });

        // dd($all_count_student);

        return view('administration::dashboard.studentstatistic', compact('user','all_count_student'));      
    }

    public function statisticStudentProvince()
    {
        $user = auth()->user();

        $all_count_student = ManagementProvince::with(['regencies.studentLevels' => function($studentlevel){
                        return $studentlevel->select('student_id', \DB::raw('MAX(level_id) as level_id, count(*) as students_count'))->groupBy('student_id');
                    }])
                        ->get()
                        ->map(function($mgmt) {
                            return [
                                'id' => $mgmt->id,
                                'name' => $mgmt->name,
                                'pimwil_code' => $mgmt->pimwil_code,
                                'kode' => $mgmt->pimwil_code,
                                'studentlevels' => $mgmt->regencies->pluck('studentLevels')->flatten()->groupBy('detail.name')->map(function ($studentlevel) {
                                    return $studentlevel->count();
                                })
                            ];
                        });

        // return $all_count_student;

        return view('administration::dashboard.studentstatisticprovince', compact('user','all_count_student'));
    }
}