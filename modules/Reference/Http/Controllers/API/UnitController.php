<?php

namespace Modules\Reference\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Core\Models\UnitPosition;
use Modules\Core\Repositories\UnitRepository;
use Modules\Reference\Http\Controllers\Controller;

class UnitController extends Controller
{
    use UnitRepository;
    /**
     * Search a listing of the resources..
     */
    public function position(Request $request)
    {

        $data = UnitPosition::with('unit', 'position')
            ->where('unit_id', $request->get('q', ''))
            ->get()->pluck('position.name', 'id');

        return response()->success([
            'message' => 'Berikut adalah data hasil pencarian dengan query "' . $request->get('q', '') . '"',
            'data' => $data
        ]);
    }
}
