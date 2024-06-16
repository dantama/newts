<?php

namespace Modules\Administration\Http\Controllers\Technical;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\Coach;
use App\Models\CoachLevel;
use App\Models\References\ProvinceRegency;
use App\Models\References\CoachType;

class ProvinceCoachController extends Controller
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

        $managements = ($isUserManagerRegency)
                            ? ManagementRegency::with('management')->fromCurrentManagerials()->get()
                            : ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

        $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

        $selected = ($isUserManagerRegency)
                        ? $mgmt->id 
                        : $mgmt->regencies->pluck('id')->toArray();

        $coachProvice = Coach::with('user')
                        ->whereProvinceIn($selected)->when($trashed, function($query, $trashed) {
                            return $query->onlyTrashed();
                        })
                        ->get();

        $members = Member::with('user')->whereRegencyIn($selected)->get();
        
        $coachProvince_count = Coach::where('managerable_type', 'App\Models\ManagementProvince')->count();

        return view('administration::coach.province.index', compact('user','coachProvice','coachProvince_count','managements','members'));  
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('coach::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $coach = new Coach([
                'managerable_type'   => 'App\Models\ManagementProvince',
                'managerable_id'     => $request->input('mgmt_id'),
                'user_id'           => $request->input('user_id')
        ]);

        $coach->save();

        return redirect()->back()->with('success', 'Pelatih <strong>'.$coach->user->profile->display_name.'</strong> berhasil disimpan');
    }

    public function storeLevel(Request $request, $coach)
    {
        
        if($request->hasFile('file')){

            $request->validate([
            'file' => 'mimes:pdf|max:2048',
            ]);

            $file = $request->file('file')->store('uploads/coachs/province-coachs');

            $coachLevel = new CoachLevel([
                    'coach_id'          => $coach,
                    'type_id'           => $request->input('type_id'),
                    'start'             => $request->input('start'),
                    'accepted'          => 0,
                    'event_id'          => $request->input('event_id'),
                    'file'              => $file
            ]);

            $coachLevel->save();

            return redirect()->back()->with('success', 'Data pelatih berhasil diperbarui');

        }

        else {

            $coachLevel = new CoachLevel([
                    'coach_id'          => $coach,
                    'type_id'           => $request->input('type_id'),
                    'start'             => $request->input('start'),
                    'accepted'          => 0,
                    'event_id'          => $request->input('event_id')
            ]);

            $coachLevel->save();

            return redirect()->back()->with('success', 'Data pelatih berhasil diperbarui');
        }
        
    }

    public function show($coach)
    {
        $coachs = Coach::with('user')->where('id',$coach)->get();

        $coachLevels = CoachLevel::with('detail')->where('coach_id',$coach)->get();

        $coachtypes = CoachType::where('code',2)->get();

        return view('administration::coach.province.detail', compact('coachs','coachLevels','coachtypes')); 
    }

    public function edit($coach)
    {
        $coachs = Coach::with('user')->where('id',$coach)->get();

        $coachLevels = CoachLevel::with('detail')->where('coach_id',$coach)->get();

        $coachtypes = CoachType::where('code',2)->get();

        return view('administration::coach.province.detail', compact('coachs','coachLevels','coachtypes')); 
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Coach $coach)
    {
        $tmp = $coach;
        $coach->delete();

        return redirect()->back()->with('success', 'Pelatih <strong>'.$coach->user->profile->display_name.'</strong> berhasil dihapus');
    }

    public function kill(Coach $coach)
    {

        $tmp = $coach;
        $coach->forceDelete();
        return redirect()->back()->with('success', 'Pelatih <strong>'.$coach->user->profile->display_name.'</strong> berhasil dihapus permanen dari sistem');
    }

    public function restore(Coach $coach)
    {

        $coach->restore();

        return redirect()->back()->with('success', 'Pelatih <strong>'.$coach->user->profile->display_name.'</strong> berhasil dipulihkan');
    }

}
