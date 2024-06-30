<?php

namespace Modules\Core\Http\Controllers\Administration;

use Illuminate\Http\Request;
use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Departement;
use Modules\Core\Models\UnitDepartement;

class UnitDepartementController extends Controller
{
    /**
     * display all resource page.
     */
    public function index(Request $request)
    {
        $types = collect(OrganizationTypeEnum::cases());
        $unitDepts = Unit::with('children.meta', 'meta', 'unit_departements.departement')
            ->search($request->get('search'))
            ->whenType($request->get('type'))
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));;

        $unit_count = Unit::count();

        return view('core::administration.unit-departement.index', compact('unitDepts', 'unit_count', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('store', Unit::class);
        $depts = Departement::all();
        $unit = Unit::find($request->input('unit'));
        $parents = UnitDepartement::with('unit', 'departement')->where('unit_id', $request->input('unit'))->get();

        return view('core::administration.unit-departement.create', compact('depts', 'unit', 'parents'));
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
    public function show(UnitDepartement $unit_departement, Request $request)
    {
        $this->authorize('update', $unit_departement);
        $depts = Departement::all();
        $unit = Unit::find($request->input('unit'));
        $parents = UnitDepartement::with('unit', 'departement')->where('unit_id', $request->input('unit'))->get();

        return view('core::administration.unit-departement.show', compact('depts', 'unit', 'unit_departement', 'parents'));
    }
}
