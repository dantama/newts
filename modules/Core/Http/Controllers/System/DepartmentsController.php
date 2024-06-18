<?php

namespace Modules\Core\Http\Controllers\System;

use Illuminate\Http\Request;
use Modules\Core\Http\Requests\System\Department\StoreRequest;
use Modules\Core\Http\Requests\System\Department\UpdateRequest;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Departement;
use Modules\Core\Repositories\OrganizationDepartmentRepository;

class DepartmentsController extends Controller
{
    use OrganizationDepartmentRepository;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', Departement::class);

        $departments = Departement::whenTrashed($request->get('trash'))
            ->search($request->get('search'))
            ->paginate($request->get('limit', 10));

        $departments_count = Departement::count();

        return view('core::system.departments.index', compact('departments', 'departments_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Departement::class);
        $departments = Departement::all();

        return view('core::system.departments.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($department = $this->storeCompanyDepartment($request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Departemen dengan nama <strong>' . $department->name . ' (' . $department->kd . ')</strong> telah berhasil dibuat.');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Departement $department)
    {
        $this->authorize('update', $department);
        $departments = Departement::all();

        return view('core::system.departments.show', compact('departments', 'department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Departement $department, UpdateRequest $request)
    {
        if ($department = $this->updateCompanyDepartment($department, $request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Departemen dengan nama <strong>' . $department->name . ' (' . $department->kd . ')</strong> telah berhasil diperbarui.');
        }
        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departement $department, Request $request)
    {
        $this->authorize('destroy', $department);

        if ($department = $this->destroyCompanyDepartment($department, $request->user())) {
            return redirect()->next()->with('success', 'Departemen dengan nama <strong>' . $department->name . ' (' . $department->kd . ')</strong> telah berhasil dihapus.');
        }
        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Departement $department, Request $request)
    {
        $this->authorize('restore', $department);

        if ($department = $this->restoreCompanyDepartment($department, $request->user())) {
            return redirect()->next()->with('success', 'Departemen dengan nama <strong>' . $department->name . ' (' . $department->kd . ')</strong> telah berhasil dipulihkan.');
        }
        return redirect()->fail();
    }
}
