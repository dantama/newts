<?php

namespace Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Event\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return view('event::dashboard', compact('user'));
    }
}
