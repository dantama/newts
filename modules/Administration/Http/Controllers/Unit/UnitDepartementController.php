<?php

namespace Modules\Administration\Http\Controllers\Unit;

use Illuminate\Http\Request;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Departement;
use Modules\Core\Models\UnitDepartement;

class UnitDepartementController extends Controller
{
    /**
     * display all resource page.
     */
    public function index(Request $request, $unit)
    {
        $this->authorize('access', UnitDepartement::class);
        $currentUnit = Unit::firstWhere('kd', $unit);
        $unitDepts = UnitDepartement::with('departement')
            ->where('unit_id', $currentUnit->id)
            ->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));;

        $unit_depts_count = UnitDepartement::with('departement')
            ->where('unit_id', $currentUnit->id)->count();

        return view('administration::units.departement.index', compact('currentUnit', 'unitDepts', 'unit_depts_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $unit)
    {
        $this->authorize('store', UnitDepartement::class);
        $currentUnit = Unit::firstWhere('kd', $unit);
        $depts = Departement::whereIsAddable(1)->get();
        $parents = UnitDepartement::with('unit', 'departement')->where('unit_id', $currentUnit->id)->get();

        return view('administration::units.departement.create', compact('depts', 'currentUnit', 'parents'));
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
    public function show(Request $request, $unit, UnitDepartement $departement)
    {
        $this->authorize('update', $departement);
        $currentUnit = Unit::firstWhere('kd', $unit);
        $depts = Departement::whereIsAddable(1)->get();
        $parents = UnitDepartement::with('unit', 'departement')->where('unit_id', $currentUnit->id)->get();

        return view('administration::units.departement.show', compact('depts', 'currentUnit', 'parents', 'departement'));
    }

    /**
     * update a new resource.
     */
    public function update(Request $request, $unit, UnitDepartement $departement)
    {
        // 
    }
}
