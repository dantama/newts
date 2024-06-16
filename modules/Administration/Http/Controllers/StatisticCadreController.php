<?php

namespace Modules\Administration\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\Student;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;


class StatisticCadreController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        $all_count = ManagementRegency::with(['memberLevels' => function($level){
                        return $level->select('member_id', \DB::raw('MAX(level_id) as level_id, count(*) as members_count'))
                        ->groupBy('member_id');
                    }])->has('members')->withCount('members')->orderBy('members_count','desc')->get()->map(function($mgmt){
                        return [
                           'name' => $mgmt->name,
                           'full_name' => $mgmt->fullName,
                           'levels' => $mgmt->memberLevels->groupBy('detail.name')->map(function($level){
                                return $level->count();
                            })->toArray()
                        ];
                    });

        return view('administration::dashboard.cadrestatistic', compact('user','all_count'));      
    }

    public function statisticCadreProvince()
    {
        $user = auth()->user();

        $all_count = ManagementProvince::with(['regencies.memberLevels' => function($level){
                        return $level->select('member_id', \DB::raw('MAX(level_id) as level_id, count(*) as members_count'))->groupBy('member_id');
                    }])
                        ->get()
                        ->map(function($mgmt) {
                            return [
                                'id' => $mgmt->id,
                                'name' => $mgmt->name,
                                'kode' => $mgmt->pimwil_code,
                                'levels' => $mgmt->regencies->pluck('memberLevels')->flatten()->groupBy('detail.name')->map(function ($level) {
                                    return $level->count();
                                })
                            ];
                        });

        return view('administration::dashboard.cadrestatisticprovince', compact('user','all_count'));
    }
}