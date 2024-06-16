<?php

namespace Modules\Administration\Http\Controllers\Management\District;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\ManagementDistrict;
use App\Models\Manager;
use App\Models\References\ProvinceRegency;
use App\Models\References\ProvinceRegencyDistric;

use Modules\Administration\Http\Requests\Management\District\StoreRequest;

class DistrictController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index()
    {
        $pd = ManagementDistrict::fromCurrentManagerials()->get();

        $pw = ManagementProvince::all();
        
        $daerah = ProvinceRegency::all();

        $managements_count = ManagementDistrict::count();
        
        $managers_count = Manager::inDistrict()->count();

        // return $pd;

        return view('administration::managements.districts.index', compact('pd','pw','daerah','managements_count','managers_count'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

    	$mgmt_district = new ManagementDistrict([
    		'mgmt_regency_id' => $request->input('mgmt_regency_id'),
    		'district_id' => $request->input('district_id'),
    		'name' => $request->input('name'),
    		'email' => $request->input('email'),
    		'phone' => $request->input('phone'),
    		'address' => $request->input('address')
    	]);

    	$mgmt_district->save();

        return redirect($request->get('next', route('administration::managements.districts.index')))->with('success', 'berhasil');
    }

}