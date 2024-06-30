<?php

namespace Modules\Administration\Http\Controllers\Manager;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Contract;
use Modules\Core\Models\Manager;
use Modules\Core\Models\Member;
use Modules\Core\Repositories\ManagerRepository;

class ManagerController extends Controller
{
    use ManagerRepository;
    /**
     * Show page.
     */
    public function index(Request $request)
    {
        $managers = Manager::with([
            'member' => fn ($m) => $m->with('level.level', 'user'),
            'unit_departement.departement',
            'contract.unit_position.position',
            'meta'
        ])->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));

        $manager_count = Manager::count();

        return view('administration::managers.index', compact('managers', 'manager_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Unit::class);
        $units = Unit::with('unit_departements.departement')->get();
        $contracts = Contract::get();

        return view('administration::managers.create', compact('units', 'contracts'));
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
    public function show(Manager $manager, Request $request)
    {
        $this->authorize('update', $manager);
        $manager->load('meta', 'contract', 'unit_departement.unit');
        $units = Unit::with('unit_departements.departement')->get();
        $contracts = Contract::get();

        return view('administration::managers.show', compact('contracts', 'manager', 'units'));
    }
}
