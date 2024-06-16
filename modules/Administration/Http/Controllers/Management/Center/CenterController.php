<?php

namespace Modules\Administration\Http\Controllers\Management\Center;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\ManagementCenter;
use App\Models\Student;
use App\Models\Member;
use Modules\Web\Models\BlogPost;

class CenterController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index()
    {
        $pp = ManagementCenter::all();

        $most_viewed_posts = BlogPost::where('views_count', '>', '0')->orderByDesc('views_count')->limit(7)->get();

        $warriors_count = Member::whereHas('levels.detail', function($code){ return $code->where('code', 3); })->count(); 

        $cadres_count = Member::whereHas('levels.detail', function($code){ return $code->where('code', 2); })->count(); 

        $students_count = Student::count();

        return view('administration::managements.centers.index', compact('pp','most_viewed_posts','warriors_count','cadres_count','students_count'));
    }

}