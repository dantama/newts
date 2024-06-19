<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Notification;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\Event;
use App\Models\EventType;
use Modules\Event\Http\Requests\Submission\StoreRequest;

use Modules\Event\Notifications\NotifyAdminCreateEvent;
use Modules\Event\Notifications\NotifyAdminCreateEventTelegram;
use Modules\Event\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $managerial = $user->flattenManagerials()->first();
        
        $events = Event::whereManagementIn($managerial->pivot)
                        ->orderByDesc('created_at')
                        ->whereApproved(0)
                        ->get();


        return view('event::submissions.index', compact('user', 'events', 'managerial'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = auth()->user();
        $managerial = $user->flattenManagerials()->first();

        $request->validate([
            'file' => 'required|max:1024'
        ]);

        $data = $request->only('name', 'content', 'type_id', 'start_at', 'end_at', 'price', 'registrable');

        $data['file'] = $request->file('file')->store('uploads/events/submission');

        // Bug exist as double manager
        // $data['management_type'] = $managerial->pivot->managerable_type;
        $data['management_type'] = \App\Models\Manager::where('user_id', $user->id)->first()->managerable_type;
        $data['management_id'] = $managerial->pivot->managerable_id;
        $data['state'] = ($data['management_type'] == 'App\Models\ManagementRegency') ? 0 : 1 ;

        if($data['management_type'] == 'App\Models\ManagementProvince') {
            $data['management'] = ManagementProvince::where('id', $managerial->pivot->managerable_id)->first()->name;
        }
        else if ($data['management_type'] == 'App\Models\ManagementRegency') {
            $data['management'] = ManagementRegency::where('id', $managerial->pivot->managerable_id)->first()->name;
        } else {
            $data['management'] = 'Pusat';
        }

        $event = new Event($data);
        $event->save();

        Notification::route('mail', 'my1985it@gmail.com')
                ->notify(new NotifyAdminCreateEvent($data));

        Notification::route('telegram', '744508004')
                ->notify(new NotifyAdminCreateEventTelegram($data));

        return redirect()->back()->with('success', 'Pengajuan berhasil terkirim!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {        
        $user = auth()->user();
        $managerial = $user->flattenManagerials()->first();

        if(Event::whereManagementIn($managerial->pivot)->find($event->id)) {
            $tmp = $event;
            $event->forceDelete();

            return redirect()->back()->with('success', 'Pengajuan <strong>'.$tmp->name.' (ID: '.$tmp->id.')</strong> berhasil dibatalkan');
        }

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }
}
