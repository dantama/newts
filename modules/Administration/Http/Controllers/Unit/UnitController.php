<?php

namespace Modules\Administration\Http\Controllers\Unit;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;
use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Repositories\UnitRepository;

class UnitController extends Controller
{
    use UnitRepository;
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request, $unit)
    {
        $user = $request->user();
        $currentUnit = Unit::firstWhere('kd', $unit);
        $param = $this->transformUnit($currentUnit);
        $types = collect(OrganizationTypeEnum::cases());

        return view('administration::units.index', compact('user', 'currentUnit', 'types'));
    }
}
