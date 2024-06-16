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


class StatisticController extends Controller
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
                           'pimwil_code' => $mgmt->management->pimwil_code,
                           'full_name' => $mgmt->fullName,
                           'levels' => $mgmt->memberLevels->groupBy('detail.name')->map(function($level){
                                return $level->count();
                            })->toArray()
                        ];
                    });

        // dd($all_count);
        // return $all_count;

        return view('administration::dashboard.statistic', compact('user','all_count'));      
    }

    public function statisticWarriorProvince()
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

        // return $all_count;

        return view('administration::dashboard.warriortatisticprovince', compact('user','all_count'));
    }
}