<?php

namespace Modules\Administration\Http\Controllers\Achievement;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\UserAchievement;
use App\Models\References\AchievementNum;
use App\Models\References\AchievementType;

class RegencyAchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $isUserManagerRegency = auth()->user()->isManagerRegencies();

        $trashed = $request->get('trash');

        $managements = ManagementRegency::with('management')->fromCurrentManagerials()->get();

        $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

        $UserAchievementRegency = UserAchievement::with('user')
                            ->whereRegencyIn($request->get('mgmt', $managements->first()->id ?? null))
                            ->when($trashed, function($query, $trashed) {
                            return $query->onlyTrashed();
                        })
                        ->get();

        $management_filtered = ManagementRegency::where('id', $request->get('mgmt', $managements->first()->id ?? null))->get();

        $members = Member::with('user')->whereRegencyIn($request->get('mgmt', $managements->first()->id ?? null))->get();

        $nums = AchievementNum::all();

        $types = AchievementType::all();
        
        $UserAchievementRegency_count = UserAchievement::inProvince()->count();

        return view('administration::achievement.regency.index', compact('user','UserAchievementRegency','UserAchievementRegency_count','members','nums','types','managements','management_filtered')); 
    }

    public function create()
    {
        return view('coach::create');
    }

    public function store(Request $request)
    {

        if($request->hasFile('file')){

            $request->validate([
            'file' => 'mimes:pdf|max:2048',
            ]);

            $file = $request->file('file')->store('uploads/achievement/regency-achievement');

            $achievement = new UserAchievement([
                'user_id'            => $request->input('user_id'),
                'managerable_type'   => 'App\Models\ManagementRegency',
                'managerable_id'     => $request->input('regency_id'),
                'name'               => $request->input('name'),
                'territory_id'       => 5,
                'type_id'            => $request->input('type_id'),
                'num_id'             => $request->input('num_id'),
                'year'               => $request->input('year'),
                'description'        => $request->input('description'),
                'file'               => $file
        ]);

        $achievement->save();

        return redirect()->back()->with('success', 'Prestasi berhasil disimpan');

        }

        else {

            $achievement = new UserAchievement([
                'user_id'            => $request->input('user_id'),
                'managerable_type'   => 'App\Models\ManagementRegency',
                'managerable_id'     => $request->input('regency_id'),
                'name'               => $request->input('name'),
                'territory_id'       => 5,
                'type_id'            => $request->input('type_id'),
                'num_id'             => $request->input('num_id'),
                'year'               => $request->input('year'),
                'description'        => $request->input('description')
        ]);

        $achievement->save();

        return redirect()->back()->with('success', 'Prestasi berhasil disimpan');
        
        }

    }


    public function edit($achievement)
    {
        $nums = AchievementNum::all();

        $types = AchievementType::all();

        $UserAchievementCentral = UserAchievement::with('user','type','num')->where('id', $achievement)->get();

        return view('administration::achievement.regency.detail', compact('UserAchievementCentral','nums','types')); 
    }

    public function show($achievement)
    {
        $nums = AchievementNum::all();

        $types = AchievementType::all();

        $UserAchievementCentral = UserAchievement::with('user','type','num')->where('id', $achievement)->get();

        return view('administration::achievement.regency.detail', compact('UserAchievementCentral','nums','types')); 
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Coach $achievement)
    {
        $tmp = $achievement;
        $achievement->delete();
        return redirect()->back()->with('success', 'berhasil dihapus');
    }

    public function kill(Coach $achievement)
    {

        $tmp = $achievement;
        $achievement->forceDelete();
        return redirect()->back()->with('success', 'berhasil dihapus permanen dari sistem');
    }

    public function restore(Coach $achievement)
    {

        $achievement->restore();

        return redirect()->back()->with('success', 'berhasil dipulihkan');
    }

}
