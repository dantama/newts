<?php

namespace Modules\Administration\Http\Controllers\Management\Perwil;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Member;
use App\Models\ManagementPerwil;
use App\Models\Manager;
use App\Models\References\OrganizationPosition;

class PerwilManagerController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {
        $trashed = $request->get('trash');

        $members = Member::with('user','levels.detail')->whereHas('levels.detail',function($code){ $code->where('code','!=',1); })->get();
        $positions = OrganizationPosition::all();

        $managements = ManagementPerwil::fromCurrentManagerials()->get();
        $managers = Manager::with('user', 'position')
                        ->when($trashed, function ($query) {
                            return $query->onlyTrashed();
                        })
                        ->whereManagementPerwilIn($request->get('mgmt', $managements->first()->id ?? null))
                        ->get();

        $managers_count = Manager::inPerwil()->count();

        return view('administration::managements.perwils-managers.index', compact('managements','managers','members','positions','managers_count'));
    }

    public function store(Request $request)
    {

        $manager = new Manager([
            'user_id' => $request->input('user_id'),
            'position_id' => $request->input('position_id'),
            'managerable_type' => 'App\Models\ManagementPerwil',
            'managerable_id' => $request->input('managerable_id')
        ]);

        $manager->save();

        return redirect($request->get('next', route('administration::managements.perwil-managers.index')))->with('success', 'berhasil');
    }

    /**
     * Change the user adminable bools.
     */
    public function adminable(Manager $perwil_manager)
    {
        $user = $perwil_manager->user;

        $user->fill([
            'adminable' => !$user->adminable
        ]);

        $user->save();

        return redirect()->back()->with('success', 'User <strong>'.$perwil_manager->user->profile->name.' ('.$perwil_manager->id.')</strong> berhasil diset menjadi '.(!$user->adminable ? 'bukan' : '').' admin!');
    }

    public function destroy(Manager $perwil_manager)
    {

        $tmp = $perwil_manager;
        $perwil_manager->delete();

        return redirect()->back()->with('success', 'Manager berhasil dihapus');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Manager $perwil_manager)
    {

        $perwil_manager->restore();

        return redirect()->back()->with('success', 'User <strong>'.$perwil_manager->user->profile->name.' ('.$perwil_manager->id.')</strong> berhasil dipulihkan');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Manager $perwil_manager)
    {

        $tmp = $perwil_manager;
        $perwil_manager->forceDelete();
        return redirect()->back()->with('success', 'User <strong>'.$tmp->user->profile->name.' ('.$tmp->id.')</strong> berhasil dihapus permanen dari sistem');
    }

    public function show($perwil_manager)
    {
        $managers = Manager::with('user', 'position')
                        ->where('id',$perwil_manager)
                        ->first();

        $positions = OrganizationPosition::all();

        return view('administration::managements.perwils-managers.edit', compact('managers','positions')); 
    }

    public function update(Request $request, $perwil_manager)
    {
        $perwil_manager = Manager::updateOrCreate(
            ['id' => $perwil_manager],
            ['position_id' => $request->input('position_id')]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

}