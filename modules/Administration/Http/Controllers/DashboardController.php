<?php

namespace Modules\Administration\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use Modules\Web\Models\BlogPost;
use Modules\Web\Models\BlogCategory;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\Student;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\ManagementDistrict;


class DashboardController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return $user;

        if (auth()->user()->isManagerDistricts()) {

            $managements = ManagementDistrict::with('management')->fromCurrentManagerials()->get();

            $warrior_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 3);
            })
                ->where('regency_id', $managements[0]['management']['id'])
                ->count();

            $cadre_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 2);
            })
                ->where('regency_id', $managements[0]['management']['id'])
                ->count();

            $students_count = Student::where('district_id', $managements[0]['id'])->count();
        } else if (auth()->user()->isManagerRegencies()) {

            $managements = ManagementRegency::with('management')->fromCurrentManagerials()->get();

            $warrior_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 3);
            })
                ->where('regency_id', $managements[0]['id'])
                ->count();

            $cadre_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 2);
            })
                ->where('regency_id', $managements[0]['id'])
                ->count();

            $students_count = Student::where('regency_id', $managements[0]['id'])->count();
        } else if (auth()->user()->isManagerProvinces()) {

            $managements = ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

            $warrior_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 3);
            })
                ->whereRegencyIn($managements[0]['regencies']->pluck('id')->toArray())
                ->count();

            $cadre_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 2);
            })
                ->whereRegencyIn($managements[0]['regencies']->pluck('id')->toArray())
                ->count();

            $students_count = Student::whereRegencyIn($managements[0]['regencies']->pluck('id')->toArray())->count();
        } else {

            $warrior_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 3);
            })->count();

            $cadre_count = Member::whereHas('levels.detail', function ($code) {
                return $code->where('code', 2);
            })->count();

            $students_count = Student::count();
        }

        $users_count = User::count();

        $categories = BlogCategory::withCount('posts')->get();

        $recent_posts = BlogPost::orderByDesc('created_at')->limit(5)->get();
        $most_viewed_posts = BlogPost::where('views_count', '>', '0')->orderByDesc('views_count')->limit(5)->get();

        $all_count = ManagementRegency::with(['memberLevels' => function ($level) {
            return $level->select('member_id', \DB::raw('MAX(level_id) as level_id, count(*) as members_count'))
                ->groupBy('member_id');
        }])->has('members')->withCount('members')->orderBy('members_count', 'desc')->take(4)->get()->map(function ($mgmt) {
            return [
                'name' => $mgmt->name,
                'full_name' => $mgmt->fullName,
                'levels' => $mgmt->memberLevels->groupBy('detail.name')->map(function ($level) {
                    return $level->count();
                })->toArray()
            ];
        });

        // return $user;

        return view('administration::dashboard.index', compact('user', 'warrior_count', 'cadre_count', 'students_count', 'users_count', 'categories', 'recent_posts', 'most_viewed_posts', 'all_count'));
    }
}
