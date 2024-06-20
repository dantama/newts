<?php

namespace Modules\Core\Http\Controllers\Administration;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Manager;
use Modules\Reference\Models\Province;

class ManagerController extends Controller
{
    /**
     * Show page.
     */
    public function index(Request $request)
    {
        $managers = Manager::with('member', 'unit_departement.departement', 'contract', 'children', 'meta')
            ->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));

        $manager_count = Manager::count();

        return view('core::administration.managers.index', compact('managers', 'manager_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Unit::class);
        $types = collect(OrganizationTypeEnum::cases());
        $provinces = Province::all();

        return view('core::administration.units.create', compact('types', 'provinces'));
    }

    /**
     * store a new resource.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Show a resource.
     */
    public function show(Unit $unit, Request $request)
    {
        $this->authorize('update', $unit);
        $unit->load('parents', 'meta');
        $types = collect(OrganizationTypeEnum::cases());

        return view('core::administration.units.show', compact('types', 'unit'));
    }
}
