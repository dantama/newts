<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Account\Models\UserLog;
use Modules\Core\Models\Member;
use Modules\Evaluation\Models\EvaluationTable;

class UnitDepartementController extends Controller
{
    /**
     * Show page.
     */
    public function index(Request $request)
    {
        $eval_array = [];

        return view('core::dashboard', [
            'user_count' => User::count(),
            'member_count' => Member::count(),
            'warrior_count' => Member::count(),
            'cadre_count' => Member::count(),
            'recent_activities' => UserLog::whereIn('modelable_type', $eval_array)->with('user.meta')->latest()->limit(5)->get()
        ]);
    }
}
