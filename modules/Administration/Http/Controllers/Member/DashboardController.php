<?php

namespace Modules\Administration\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Administration\Http\Controllers\Controller;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\BlogPost;
use Modules\Core\Enums\LevelTypeEnum;
use Modules\Core\Models\Level;
use Modules\Core\Models\Member;
use Modules\Core\Models\Unit;
use Modules\Core\Repositories\UnitRepository;

class DashboardController extends Controller
{
    use UnitRepository;
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $managerUnit = $user->manager->unit_departement->unit_id;
        $param = $managerUnit ? $this->transformUnit(Unit::find($managerUnit)) : '';
        $users_count = User::count();

        $memberships = [];
        foreach (collect(LevelTypeEnum::cases()) as $key => $level) {
            $levels = Level::where('type', $level->value)->pluck('id')->toArray();
            $memberships[$level->label()] = [
                $memberships[$level->label()]['member'] = Member::with('user', 'unit', 'levels.level', 'meta')
                    ->whenUnits($param)
                    ->whenLevelIn($levels)
                    ->count(),
                $memberships[$level->label()]['color'] = $level->color(),
                $memberships[$level->label()]['icon'] = $level->icon()
            ];
        }

        $categories = BlogCategory::withCount('posts')->get();
        $recent_posts = BlogPost::orderByDesc('created_at')->limit(5)->get();
        $most_viewed_posts = BlogPost::where('views_count', '>', '0')->orderByDesc('views_count')->limit(5)->get();

        return view('administration::dashboard', compact('user', 'users_count', 'categories', 'recent_posts', 'most_viewed_posts', 'memberships'));
    }
}
