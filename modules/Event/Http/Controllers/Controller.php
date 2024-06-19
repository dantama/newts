<?php

namespace Modules\Event\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\Level;
use App\Models\Event;
use App\Models\References\ProvinceRegency;
use App\Models\References\Employment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AppController;

class Controller extends AppController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $state = (\App\Models\Manager::where('user_id', $user->id)->first()->managerable_type== 'App\Models\ManagementDistrict') ? 0 : 1;
        $active_events = Event::whereState($state)->fromManagerial($user)->whereApproved(1)->whereRaw('? BETWEEN start_at AND end_at', [date('Y-m-d')])->get();
        $upcoming_events = Event::fromManagerial($user)->whereApproved(1)->whereDate('start_at', '>', date('Y-m-d'))->get();
        $stats = [
            'Event Nasional'    => [Event::inCenter()->count(), 'primary'],
            'Event Wilayah'    => [Event::inProvince()->count(), 'success'],
            'Event Daerah'    => [Event::inRegency()->count(), 'danger'],
        ];

        // return $active_events;

        return view('event::home', compact('user', 'stats', 'active_events', 'upcoming_events', 'state')); 
    }
}

