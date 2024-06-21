<?php

namespace Modules\Reference\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Member;
use Modules\Core\Models\Unit;
use Modules\Core\Repositories\UnitRepository;
use Modules\Reference\Http\Controllers\Controller;

class MemberController extends Controller
{
    use UnitRepository;
    /**
     * Search a listing of the resources..
     */
    public function index(Request $request)
    {
        $param = $request->get('q') ? $this->transformUnit(Unit::find($request->get('q'))) : '';

        $data = Member::with('user', 'unit', 'level', 'meta')
            ->whenUnits($param)
            ->get()->pluck('user.name', 'id');

        return response()->success([
            'message' => 'Berikut adalah data hasil pencarian dengan query "' . $request->get('q', '') . '"',
            'data' => $data
        ]);
    }
}
