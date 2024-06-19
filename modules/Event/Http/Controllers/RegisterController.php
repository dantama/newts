<?php

namespace Modules\Event\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistrant;
use App\Models\Student;
use App\Models\Member;
use Illuminate\Http\Request;
use Modules\Event\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request, Event $event)
    {
        $user = auth()->user();
        $managerial = $user->flattenManagerials()->first();
        $state = $request->get('state');
        $code = array(2,3);

        $students = Student::with(['user', 'levels' => function ($level) {
                        return $level->orderByDesc('level_id');
                    }])->whereDistrictId($managerial->id)->get();


        if(auth()->user()->isManagerProvinces()){
            $mgmt = \App\Models\ManagementRegency::whereMgmtProvinceId($managerial->id)->get()->pluck('id')->toArray();
            $members = Member::with(['user', 'levels' => function ($level) {
                            return $level->orderByDesc('level_id');
                        }])->whereCodeIn($code)->whereRegencyIn($mgmt)->get();
        }else if(auth()->user()->isManagerRegencies()) {
            $members = Member::with(['user', 'levels' => function ($level) {
                            return $level->orderByDesc('level_id');
                        }])->whereCodeIn(2)->inManagerial($managerial)->get();
        }

        $registered_users = $event->registrants()
                                  ->with('user', 'level')
                                  ->whereIn('user_id', array_merge($students->pluck('user.id')->toArray() ?? [], $members->pluck('user.id')->toArray() ?? []))
                                  ->get();

        // return $members;

        return view('event::register.index', compact('user', 'event', 'managerial', 'students', 'members', 'registered_users','state'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $refid = time();

        if($request->has('users')){
            $data = [];
            foreach ($request->input('users') as $id => $level_id) {
                if(isset($level_id)) {
                    $data[] = [
                        'user_id'   => $id,
                        'level_id'  => $level_id,
                        'refid'     => $refid
                    ];
                }
            }

            $event->registrants()->createMany($data);

            // return redirect()->route('event::register.index', ['event' => $event])
            return redirect()->back()
                        ->with('success', 'Pendaftaran berhasil, silahkan lanjutkan ke bagian upload bukti pembayaran!');
        }

        // return redirect()->route('event::register.index', ['event' => $event])
        return redirect()->back()
                        ->with('danger', 'Terjadi kegagalan, tidak ada data yang disimpan!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function payment(Request $request, $refid)
    {
        $this->validate($request, [
            'file'  => 'required|file|image|max:1024'
        ]);

        $file = $request->file('file')->store('uploads/events/payments');

        EventRegistrant::where('refid', $refid)->update([
            'file' => $file
        ]);

        return redirect()->back()
                    ->with('success', 'Pembayaran berhasil, segera konfirmasi status pembayaran ke Admin!');
    }

    /**
     * Mark as pass.
     */
    public function pass(Request $request, Event $event, $refid)
    {
        $as = $event->registrants()->where('refid', $refid)->firstOrFail();

        $event->registrants()->where('refid', $refid)->update([
            'passed_at' => $as->passed_at ? null : now()
        ]);

        return redirect()->back()
                    ->with('success', 'Pendaftaran peserta dengan Ref ID '.$refid.' berhasil diupdate!');
    }

    /**
     * Delete specified resource.
     */
    public function delete(Request $request, Event $event, $refid)
    {
        $event->registrants()->where('refid', $refid)->delete();

        return redirect()->back()
                    ->with('success', 'Pendaftaran peserta dengan Ref ID '.$refid.' berhasil dihapus!');
    }
}
