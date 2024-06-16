<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Models\Employee;
use Modules\Account\Models\User;
use Modules\Account\Models\UserLog;
use Modules\Evaluation\Models\Evaluation;
use Modules\Evaluation\Models\EvaluationCategory;
use Modules\Evaluation\Models\EvaluationEmployee;
use Modules\Evaluation\Models\EvaluationQuestion;
use Modules\Evaluation\Models\EvaluationTable;

class DashboardController extends Controller
{
    /**
     * Show page.
     */
    public function index(Request $request)
    {
        $eval_array = [];

        return view('admin::dashboard', [
            'user_count' => User::count(),
            'member_count' => Employee::count(),
            'warrior_count' => Evaluation::count(),
            'cadre_count' => EvaluationTable::count(),
            'recent_activities' => UserLog::whereIn('modelable_type', $eval_array)->with('user.meta')->latest()->limit(5)->get()
        ]);
    }
}
