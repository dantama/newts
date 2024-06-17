<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Models\UserLog;

class DashboardController extends Controller
{
    /**
     * Show page.
     */
    public function index(Request $request)
    {
        return view('blog::dashboard');
    }
}
