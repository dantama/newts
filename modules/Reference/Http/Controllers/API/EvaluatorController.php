<?php

namespace Modules\Reference\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Account\Models\Employee;
use Modules\Reference\Http\Controllers\Controller;

class EvaluatorController extends Controller
{
    /**
     * Search a listing of the resources..
     */
    public function searchParent(Request $request)
    {
        $data = Employee::with('user', 'position.position.parents')->find($request->get('q', ''))->position->position->parents->pluck('pivot.parent_id');
        return response()->success([
            'message' => 'Berikut adalah data hasil pencarian dengan query "' . $request->get('q', '') . '"',
            'data' => Employee::with('user', 'position.position')->wherehas('position', fn ($p) => $p->whereIn('position_id', $data))->get()->map(function ($e) {
                return [
                    'id' => $e->id,
                    'name' => $e->user->name
                ];
            })
        ]);
    }
}
