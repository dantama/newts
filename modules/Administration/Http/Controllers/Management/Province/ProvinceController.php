<?php

namespace Modules\Administration\Http\Controllers\Management\Province;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\Manager;
use App\Models\ManagementProvince;
use App\Models\References\Province;

use Modules\Administration\Http\Requests\Management\Province\StoreRequest;

class ProvinceController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index()
    {
        $managements = ManagementProvince::fromCurrentManagerials()->get();
        $provinces = Province::get();

        $managements_count = ManagementProvince::count();
        $managers_count = Manager::inProvince()->count();

        return view('administration::managements.provinces.index', compact('managements','provinces','managements_count','managers_count'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        //return dd($data);

    	$mgmt_province = new ManagementProvince([
    		'mgmt_id' => 1,
    		'province_id' => $request->input('province_id'),
    		'name' => $request->input('name'),
    		'email' => $request->input('email'),
    		'phone' => $request->input('phone'),
    		'pimwil_code' => $request->input('code'),
    		'address' => $request->input('address'),
    		'district_id' => $request->input('district_id')
    	]);

    	$mgmt_province->save();

        return redirect($request->get('next', route('administration::managements.provinces.index')))->with('success', 'berhasil');
    }

    public function show($id)
    {
        $province = ManagementProvince::where('id',$id)->get();

        return view('administration::managements.provinces.edit', compact('province')); 
    }

    public function update(Request $request, $id)
    {
        $province = ManagementProvince::where('id',$id)->first();
        $province->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'pimwil_code' => $request->input('code'),
                    'address' => $request->input('address')
                ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }
}