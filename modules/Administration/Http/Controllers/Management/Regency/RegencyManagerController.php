<?php

namespace Modules\Administration\Http\Controllers\Management\Regency;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Member;
use App\Models\ManagementRegency;
use App\Models\Manager;
use App\Models\References\OrganizationPosition;

class RegencyManagerController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {
        $trashed = $request->get('trash');

        $members = Member::with('user','levels.detail')->whereHas('levels.detail',function($code){ $code->where('code','!=',1); })->get();
        $positions = OrganizationPosition::all();        

        $managements = ManagementRegency::with('management')->fromCurrentManagerials()->get();

        $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

        $managers = Manager::with('user', 'position')
                        ->when($trashed, function ($query) {
                            return $query->onlyTrashed();
                        })
                        ->whereManagementRegenciesIn($request->get('mgmt', $managements->first()->id ?? null))
                        ->get();

        $managers_count = Manager::inRegency()->count();     

        return view('administration::managements.regencies-managers.index', compact('managements', 'mgmt', 'managers','positions','members','managers_count'));
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

        return redirect()->back()->with('success', 'User <strong>'.$manager->user->profile->name.' ('.$manager->id.')</strong> berhasil diset menjadi '.(!$user->adminable ? 'bukan' : '').' admin!');
    }

    public function store(Request $request)
    {

        $manager = new manager([
            'user_id' => $request->input('user_id'),
            'position_id' => $request->input('position_id'),
            'managerable_type' => 'App\Models\ManagementRegency',
            'managerable_id' => $request->input('managerable_id')
        ]);

        $manager->save();

        return redirect($request->get('next', route('administration::managements.regencies-managers.index')))->with('success', 'berhasil');
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

        return redirect()->back()->with('success', 'User <strong>'.$manager->user->profile->name.' ('.$manager->id.')</strong> berhasil dipulihkan');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Manager $manager)
    {

        $tmp = $manager;
        $manager->forceDelete();
        return redirect()->back()->with('success', 'User <strong>'.$tmp->user->profile->name.' ('.$tmp->id.')</strong> berhasil dihapus permanen dari sistem');
    }

    public function show($manager)
    {
        $managers = Manager::with('user', 'position')
                        ->where('id',$manager)
                        ->get();

        $positions = OrganizationPosition::all();

        return view('administration::managements.regencies-managers.edit', compact('managers','positions')); 
    }

    public function update(Request $request, $manager)
    {
        $manager = Manager::updateOrCreate(
            ['id' => $manager],
            ['position_id' => $request->input('position_id')]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

}