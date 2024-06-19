<?php

namespace Modules\Core\Http\Controllers\Administration;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;

class UnitController extends Controller
{
    /**
     * Show page.
     */
    public function index(Request $request)
    {
        $central = Unit::where('type', OrganizationTypeEnum::CENTER->value)->first();
        $regions = Unit::with('children.meta', 'meta')
            ->search($request->get('search'))
            ->whereIn('type', [OrganizationTypeEnum::REGION->value, OrganizationTypeEnum::PERWIL->value])
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));

        $region_count = Unit::whereIn('type', [OrganizationTypeEnum::REGION->value, OrganizationTypeEnum::PERWIL->value])->count();

        return view('core::administration.units.index', compact('central', 'regions', 'region_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Unit::class);
        $types = collect(OrganizationTypeEnum::cases());

        return view('core::administration.units.create', compact('types'));
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