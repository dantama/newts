<?php

namespace Modules\Core\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Requests\System\Role\StoreRequest;
use Modules\Admin\Http\Requests\System\Role\UpdateRequest;
use Modules\Admin\Http\Requests\System\Role\SyncPermissionsRequest;
use Modules\Admin\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', Role::class);

        $roles = Role::with('permissions')
            ->withCount('users')
            ->whenTrashed($request->get('trash'))
            ->search($request->get('search'))
            ->paginate($request->get('limit', 10));

        $roles_count = Role::count();

        return view('admin::system.roles.index', compact('roles', 'roles_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Role::class);

        $roles = Role::withoutTrashed()->get();

        return view('admin::system.roles.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $role = new Role(Arr::only($request->transformed()->toArray(), ['kd', 'name']));
        if ($role->save()) {
            Auth::user()->log('membuat peran baru ' . $role->name . ' <strong>[ID: ' . $role->id . ']</strong>', Role::class, $role->id);
            return redirect()->next()->with('success', 'Peran dengan nama <strong>' . $role->name . ' (' . $role->kd . ')</strong> telah berhasil dibuat.');
        }

        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $this->authorize('update', $role);

        $role->loadCount('users');
        $permissions = Permission::all();

        return view('admin::system.roles.show', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Role $role, UpdateRequest $request)
    {
        $role = $role->fill(Arr::only($request->transformed()->toArray(), ['kd', 'name']));
        if ($role->save()) {
            Auth::user()->log('memperbarui peran ' . $role->name . ' <strong>[ID: ' . $role->id . ']</strong>', CompanyRole::class, $role->id);
            return redirect()->next()->with('success', 'Peran <strong>' . $role->name . ' (' . $role->kd . ')</strong> telah berhasil diperbarui.');
        }

        return redirect()->fail();
    }

    /**
     * Sync permissions with the specified resource in storage.
     */
    public function permissions(Role $role, SyncPermissionsRequest $request)
    {
        if ($role->permissions()->sync($request->transformed()->toArray()['permissions'] ?? [])) {
            Auth::user()->log('memperbarui hak akses peran ' . $role->name . ' <strong>[ID: ' . $role->id . ']</strong>', CompanyRole::class, $role->id);
            return redirect()->next()->with('success', 'Hak akses peran <strong>' . $role->name . ' (' . $role->kd . ')</strong> telah berhasil diperbarui.');
        }

        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('destroy', $role);

        if (!$role->trashed() && $role->delete()) {
            Auth::user()->log('menghapus peran ' . $role->name . ' <strong>[ID: ' . $role->id . ']</strong>', CompanyRole::class, $role->id);

            return redirect()->next()->with('success', 'Peran <strong>' . $role->name . ' (' . $role->kd . ')</strong> telah berhasil dihapus.');
        }

        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Role $role)
    {
        $this->authorize('restore', $role);

        if ($role->trashed() && $role->restore()) {
            Auth::user()->log('memulihkan peran ' . $role->name . ' <strong>[ID: ' . $role->id . ']</strong>', CompanyRole::class, $role->id);

            return redirect()->next()->with('success', 'Peran <strong>' . $role->name . ' (' . $role->kd . ')</strong> telah berhasil dipulihkan.');
        }

        return redirect()->fail();
    }
}
