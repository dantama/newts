<?php

namespace Modules\Core\Http\Controllers\System;

use App\Models\Role;
use Illuminate\Http\Request;
use Modules\core\Http\Requests\System\Position\StoreRequest;
use Modules\core\Http\Requests\System\Position\UpdateRequest;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Departement;
use Modules\Core\Models\Position;
use Modules\Core\Repositories\OrganizationPositionRepository;

class PositionController extends Controller
{
    use OrganizationPositionRepository;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', Position::class);

        $departments = Departement::all();

        $positions = Position::with('departement')
            ->whenDeptId($request->get('departement'))
            ->whenTrashed($request->get('trash'))
            ->search($request->get('search'))
            ->paginate($request->get('limit', 10));

        $positions_count = Position::count();

        return view('core::system.positions.index', compact('departments', 'positions', 'positions_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Position::class);

        $roles = Role::all();
        $departments = Departement::all();
        $positions = Position::with('departement')->get()->groupBy('department.name');

        return view('core::system.positions.create', compact('roles', 'positions', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($department = $this->storeCompanyPosition($request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Jabatan baru dengan nama <strong>' . $department->name . ' (' . $department->kd . ')</strong> telah berhasil dibuat.');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position)
    {
        $this->authorize('update', $position);

        $position = $position->load('children', 'parents', 'meta');
        $roles = Role::all();
        $departments = Departement::all();
        $positions = Position::with('departement')->get()->groupBy('departement.name');

        return view('core::system.positions.show', compact('position', 'roles', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Position $position, UpdateRequest $request)
    {
        if ($position = $this->updateCompanyPosition($position, $request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Jabatan <strong>' . $position->name . ' (' . $position->kd . ')</strong> telah berhasil diperbarui.');
        }
        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position, Request $request)
    {
        $this->authorize('destroy', $position);

        if ($position = $this->destroyCompanyPosition($position, $request->user())) {
            return redirect()->next()->with('success', 'Jabatan <strong>' . $position->name . ' (' . $position->kd . ')</strong> telah berhasil dihapus.');
        }
        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Position $position, Request $request)
    {
        $this->authorize('restore', $position);
        if ($position = $this->restoreCompanyPosition($position, $request->user())) {
            return redirect()->next()->with('success', 'Jabatan <strong>' . $position->name . ' (' . $position->kd . ')</strong> telah berhasil dipulihkan.');
        }
        return redirect()->fail();
    }
}
