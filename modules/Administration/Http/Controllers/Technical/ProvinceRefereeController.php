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

class ProvinceRefereeController extends Controller
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

        $refereeProvice = Referee::with('user')
                        ->whereProvinceIn($selected)->when($trashed, function($query, $trashed) {
                            return $query->onlyTrashed();
                        })
                        ->get();

        $members = Member::with('user')->whereRegencyIn($selected)->get();
        
        $refereeProvince_count = Referee::where('managerable_type', 'App\Models\ManagementProvince')->count();

        return view('administration::referee.province.index', compact('user','refereeProvice','refereeProvince_count','managements','members'));  
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('referee::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $referee = new Referee([
                'managerable_type'   => 'App\Models\ManagementProvince',
                'managerable_id'     => $request->input('mgmt_id'),
                'user_id'            => $request->input('user_id')
        ]);

        $referee->save();

        return redirect()->back()->with('success', 'Wasit <strong>'.$referee->user->profile->display_name.'</strong> berhasil disimpan');
    }

    public function storeLevel(Request $request, $referee)
    {
        
        if($request->hasFile('file')){

            $request->validate([
            'file' => 'mimes:pdf|max:2048',
            ]);

            $file = $request->file('file')->store('uploads/referee/province-referee');

            $refereeLevel = new RefereeLevel([
                    'referee_id'        => $referee,
                    'type_id'           => $request->input('type_id'),
                    'start'             => $request->input('start'),
                    'accepted'          => 0,
                    'event_id'          => $request->input('event_id'),
                    'file'              => $file
            ]);

            $refereeLevel->save();

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

        $refereeTypes = RefereeType::where('code',2)->get();

        return view('administration::referee.province.detail', compact('referees','refereeLevels','refereeTypes')); 
    }

    public function edit($referee)
    {
        $referees = Referee::with('user')->where('id',$referee)->get();

        $refereeLevels = RefereeLevel::with('detail')->where('referee_id',$referee)->get();

        $refereeTypes = RefereeType::where('code',2)->get();

        return view('administration::referee.province.detail', compact('referees','refereeLevels','refereeTypes')); 
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Referee $referee)
    {
        $tmp = $referee;
        $referee->delete();

        return redirect()->back()->with('success', 'Wasit <strong>'.$referee->user->profile->display_name.'</strong> berhasil dihapus');
    }

    public function kill(Referee $referee)
    {

        $tmp = $referee;
        $referee->forceDelete();
        return redirect()->back()->with('success', 'Wasit <strong>'.$referee->user->profile->display_name.'</strong> berhasil dihapus permanen dari sistem');
    }

    public function restore(Referee $referee)
    {

        $referee->restore();

        return redirect()->back()->with('success', 'Wasit <strong>'.$referee->user->profile->display_name.'</strong> berhasil dipulihkan');
    }

}
