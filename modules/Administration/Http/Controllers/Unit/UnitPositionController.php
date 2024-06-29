<?php

namespace Modules\Administration\Http\Controllers\Unit;

use Illuminate\Http\Request;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\position;
use Modules\Core\Models\UnitPosition;

class UnitPositionController extends Controller
{
    /**
     * display all resource page.
     */
    public function index(Request $request, $unit)
    {
        $this->authorize('access', UnitPosition::class);
        $currentUnit = Unit::firstWhere('kd', $unit);
        $unitPoss = UnitPosition::with('position')
            ->where('unit_id', $currentUnit->id)
            ->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));;

        $unit_poss_count = UnitPosition::with('position')
            ->where('unit_id', $currentUnit->id)->count();

        return view('administration::units.position.index', compact('currentUnit', 'unitPoss', 'unit_poss_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $unit)
    {
        $this->authorize('store', UnitPosition::class);
        $currentUnit = Unit::firstWhere('kd', $unit);
        $positions = Position::all();
        $parents = UnitPosition::with('unit', 'position')->where('unit_id', $currentUnit->id)->get();

        return view('administration::units.position.create', compact('positions', 'currentUnit', 'parents'));
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
    public function show(Request $request, $unit, UnitPosition $position)
    {
        $this->authorize('update', $position);
        $currentUnit = Unit::firstWhere('kd', $unit);
        $positions = Position::all();
        $parents = UnitPosition::with('unit', 'position')->where('unit_id', $currentUnit->id)->get();

        return view('administration::units.position.show', compact('positions', 'currentUnit', 'parents', 'position'));
    }

    /**
     * update a new resource.
     */
    public function update(Request $request, $unit, UnitPosition $position)
    {
        // 
    }
}
