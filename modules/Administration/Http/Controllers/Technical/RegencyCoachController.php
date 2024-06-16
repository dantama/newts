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

class RegencyCoachController extends Controller
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

        $coachRegency = Coach::with('user','coachlevel.detail','coachlevel.event')
                        ->when($trashed, function($query, $trashed) {
                            return $query->onlyTrashed();
                        })
                        ->whereManagementRegenciesIn($request->get('mgmt', $managements->first()->id ?? null))
                        ->get();

        $members = Member::with('user')->whereRegencyIn($request->get('mgmt', $managements->first()->id ?? null))->get();
        
        $coachRegency_count = Coach::inRegency()->count();

        return view('administration::coach.regency.index', compact('user','coachRegency','coachRegency_count','managements','members'));  
    }

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
                'managerable_type'   => 'App\Models\ManagementRegency',
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

            $file = $request->file('file')->store('uploads/coachs/regency-coachs');

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

        $coachtypes = CoachType::where('code',1)->get();

        return view('administration::coach.regency.detail', compact('coachs','coachLevels','coachtypes')); 
    }

    public function edit($id)
    {
        $coachs = Coach::with('user')->where('id',$coach)->get();

        $coachLevels = CoachLevel::with('detail')->where('coach_id',$coach)->get();

        $coachtypes = CoachType::where('code',1)->get();

        return view('administration::coach.regency.detail', compact('coachs','coachLevels','coachtypes')); 
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
