<?php

namespace Modules\Administration\Http\Controllers\Management\Center;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Member;
use App\Models\ManagementCenter;
use App\Models\Manager;
use App\Models\References\OrganizationPosition;

class CenterManagerController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {
        $trashed = $request->get('trash', false);

        $members = Member::with('user', 'levels.detail')->whereHas('levels.detail', function ($code) {
            $code->where('code', 3);
        })->get();
        $positions = OrganizationPosition::all();

        $managers = Manager::with('user', 'position')
            ->has('user')
            ->when($trashed, function ($query) {
                return $query->onlyTrashed();
            })
            ->whereManagementCentersIn(1)
            ->get();

        $managers_count = Manager::inCenter()->count();

        return view('administration::managements.centers-managers.index', compact('managers', 'positions', 'members', 'managers_count'));
    }

    public function store(Request $request)
    {
        $manager = new Manager([
            'user_id' => $request->input('user_id'),
            'position_id' => $request->input('position_id'),
            'managerable_type' => 'App\Models\ManagementCenter',
            'managerable_id' => 1
        ]);

        $manager->save();

        return redirect($request->get('next', route('administration::managements.centers-managers.index')))->with('success', 'berhasil');
    }

    /**
     * Change the user adminable bools.
     */
    public function adminable(Manager $manager)
    {
        $user = $manager->user;

        $user->fill([
            'adminable' => !$user->adminable
        ]);

        $user->save();

        return redirect()->back()->with('success', 'User <strong>' . $manager->user->profile->name . ' (' . $manager->id . ')</strong> berhasil diset menjadi ' . (!$user->adminable ? 'bukan' : '') . ' admin!');
    }

    public function destroy(Manager $manager)
    {

        $tmp = $manager;
        $manager->delete();

        return redirect()->back()->with('success', 'Manager berhasil dihapus');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Manager $manager)
    {

        $manager->restore();

        return redirect()->back()->with('success', 'User <strong>' . $manager->user->profile->name . ' (' . $manager->id . ')</strong> berhasil dipulihkan');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Manager $manager)
    {

        $tmp = $manager;
        $manager->forceDelete();
        return redirect()->back()->with('success', 'User <strong>' . $tmp->user->profile->name . ' (' . $tmp->id . ')</strong> berhasil dihapus permanen dari sistem');
    }

    public function show($manager)
    {
        $managers = Manager::with('user', 'position')
            ->where('id', $manager)
            ->get();

        $positions = OrganizationPosition::all();

        return view('administration::managements.centers-managers.edit', compact('managers', 'positions'));
    }

    public function update(Request $request, $manager)
    {
        $manager = Manager::updateOrCreate(
            ['id' => $manager],
            ['position_id' => $request->input('position_id')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }
}
