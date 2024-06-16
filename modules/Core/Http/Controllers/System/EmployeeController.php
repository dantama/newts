<?php

namespace Modules\Core\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Enums\ContractTypeEnum;
use Modules\Account\Models\Employee;
use Modules\Admin\Repositories\EmployeeRepository;
use Modules\Admin\Http\Requests\System\Employee\StoreRequest;
use Modules\Admin\Http\Requests\System\Employee\UpdateRequest;
use Modules\Admin\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    use EmployeeRepository;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', Employee::class);

        $employees = Employee::with('user.meta', 'position')
            ->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));

        $employees_count = Employee::count();

        return view('hrms::employment.employees.index', compact('employees', 'employees_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Employee::class);

        $contracts = ContractTypeEnum::cases();
        return view('hrms::employment.employees.create', compact('contracts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($employee = $this->storeEmployee($request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Karyawan baru dengan nama <strong>' . $employee->user->name . ' (' . $employee->user->username . ')</strong> berhasil dibuat dengan sandi <strong>' . $request->password . '</strong>');
        }
        return redirect()->fail();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Employee $employee, UpdateRequest $request)
    {
        if ($employee = $this->updateEmployee($employee, $request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Informasi kepegawaian <strong>' . $employee->user->name . ' (' . $employee->user->username . ')</strong> telah berhasil diperbarui.');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employee = $employee->load('user.meta', 'positions');

        return view('hrms::employment.employees.show', compact('employee'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee, Request $request)
    {
        $this->authorize('destroy', $employee);
        if ($employee = $this->destroyEmployee($employee, $request->user())) {
            return redirect()->next()->with('success', 'Karyawan <strong>' . $employee->user->name . ' (' . $employee->user->username . ')</strong> berhasil dihapus');
        }
        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Employee $employee, Request $request)
    {
        $this->authorize('restore', $employee);
        if ($employee = $this->restoreEmployee($employee, $request->user())) {
            return redirect()->next()->with('success', 'Karyawan <strong>' . $employee->user->name . ' (' . $employee->user->username . ')</strong> berhasil dipulihkan');
        }
        return redirect()->fail();
    }
}
