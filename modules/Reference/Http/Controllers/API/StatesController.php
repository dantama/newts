<?php

namespace Modules\Reference\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Reference\Models\ProvinceRegencyDistrict;
use Modules\Reference\Http\Controllers\Controller;

class StatesController extends Controller
{
    /**
     * Search a listing of the resources..
     */
    public function searchDistricByRegency(Request $request)
    {
        $data = ProvinceRegencyDistrict::where('regency_id', $request->input('q'))->pluck('name', 'id');
        return response()->success([
            'message' => 'Berikut adalah data hasil pencarian dengan query "' . $request->get('q', '') . '"',
            'data' => $data
        ]);
    }
}
