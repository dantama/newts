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
use App\Models\Referee;
use App\Models\RefereeLevel;
use App\Models\References\ProvinceRegency;
use App\Models\References\RefereeType;

class CenterRefereeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $trashed = $request->get('trash');

        $refereeCentral = Referee::with('user')->inCenter()->when($trashed, function($query, $trashed) {
                            return $query->onlyTrashed();
                        })
                        ->get();

        $members = Member::with('user')->get();
        
        $refereeCentral_count = Referee::where('managerable_type', 'App\Models\ManagementCenter')->count();

        return view('administration::referee.center.index', compact('user','refereeCentral','refereeCentral_count','members')); 
    }

    public function create()
    {
        return view('Referee::create');
    }

    public function store(Request $request)
    {

        $referee = new Referee([
                'managerable_type'   => 'App\Models\ManagementCenter',
                'managerable_id'     => 1,
                'user_id'           => $request->input('user_id')
        ]);

        $referee->save();

        return redirect()->back()->with('success', 'Pelatih <strong>'.$referee->user->profile->display_name.'</strong> berhasil disimpan');
    }

    public function storeLevel(Request $request, $referee)
    {
        
        if($request->hasFile('file')){

            $request->validate([
            'file' => 'mimes:pdf|max:2048',
            ]);

            $file = $request->file('file')->store('uploads/referees/center-referees');

            $RefereeLevel = new RefereeLevel([
                    'referee_id'        => $referee,
                    'type_id'           => $request->input('type_id'),
                    'start'             => $request->input('start'),
                    'accepted'          => 0,
                    'event_id'          => $request->input('event_id'),
                    'file'              => $file
            ]);

            $RefereeLevel->save();

            return redirect()->back()->with('success', 'Data Wasit berhasil diperbarui');

        }

        else {

            $refereeLevel = new RefereeLevel([
                    'referee_id'        => $referee,
                    'type_id'           => $request->input('type_id'),
                    'start'             => $request->input('start'),
                    'accepted'          => 0,
                    'event_id'          => $request->input('event_id')
            ]);

            $refereeLevel->save();

            return redirect()->back()->with('success', 'Data Wasit berhasil diperbarui');
        }
        
    }

    public function show($referee)
    {
        $referees = Referee::with('user')->where('id',$referee)->get();

        $refereeLevels = RefereeLevel::with('detail')->where('referee_id',$referee)->get();

        $refereetypes = RefereeType::where('code',3)->get();

        return view('administration::referee.center.detail', compact('referees','refereeLevels','refereetypes')); 
    }

    public function edit($Referee)
    {
        $referees = Referee::with('user')->where('id',$referee)->get();

        $refereeLevels = RefereeLevel::with('detail')->where('referee_id',$referee)->get();

        return view('administration::referee.center.detail', compact('referees','refereeLevels')); 
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Referee $Referee)
    {
        $tmp = $referee;
        $referee->delete();

        return redirect()->back()->with('success', 'Wasit <strong>'.$referee->user->profile->display_name.'</strong> berhasil dihapus');
    }

    public function kill(Referee $Referee)
    {

        $tmp = $referee;
        $referee->forceDelete();
        return redirect()->back()->with('success', 'Wasit <strong>'.$referee->user->profile->display_name.'</strong> berhasil dihapus permanen dari sistem');
    }

    public function restore(Referee $Referee)
    {

        $referee->restore();

        return redirect()->back()->with('success', 'Wasit <strong>'.$referee->user->profile->display_name.'</strong> berhasil dipulihkan');
    }

}
