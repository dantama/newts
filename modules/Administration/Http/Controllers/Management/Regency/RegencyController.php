<?php

namespace Modules\Administration\Http\Controllers\Management\Regency;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\Manager;
use App\Models\References\ProvinceRegency;

use Modules\Administration\Http\Requests\Management\Regency\StoreRequest;

class RegencyController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index()
    {
        $pd = ManagementRegency::fromCurrentManagerials()->get();

        $pw = ManagementProvince::all();
        
        $daerah = ProvinceRegency::all();

        $managements_count = ManagementRegency::count();
        
        $managers_count = Manager::inRegency()->count();

        // return $pd;

        return view('administration::managements.regencies.index', compact('pd','pw','daerah','managements_count','managers_count'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

    	$mgmt_province_regency = new ManagementRegency([
    		'mgmt_province_id' => $request->input('province_id'),
    		'regency_id' => $request->input('regency_id'),
    		'name' => $request->input('name'),
    		'email' => $request->input('email'),
    		'phone' => $request->input('phone'),
    		'pimda_code' => $request->input('code'),
    		'address' => $request->input('address'),
    		'district_id' => $request->input('district_id')
    	]);

    	$mgmt_province_regency->save();

        return redirect($request->get('next', route('administration::managements.regencies.index')))->with('success', 'berhasil');
    }

    public function registers()
    {
        $pd = ManagementRegency::all();
        
        $opened = ManagementRegency::where('opened',1)->where('type','!=',0)->get();

        // return $opened;

        return view('administration::managements.regencies.register', compact('pd','opened'));
    }

    public function updateregisters(Request $request)
    {
        $open = ManagementRegency::where('opened', 1)->count();

        if ($open >= 5) {

            return redirect()->back()->with('danger', 'Pimda sedang melakukan pendaftaran sudah lebih dari 5');

        } else {

            $reg = ManagementRegency::where('id',$request->input('regency_id'))->first();

            $reg->update([
                    'opened' => 1,
                    'type'   => $request->input('as')
            ]);

            return redirect($request->get('next', route('administration::managements.regencies.index')))->with('success', 'berhasil, Pendaftaran Dibuka!');


        }

    }

    public function resetregisters(Request $request, $regency)
    {

        $reg = ManagementRegency::where('id',$regency)->update([
                'opened' => 0,
                'type'   => 0
        ]);

        return redirect($request->get('next', route('administration::managements.regencies.index')))->with('success', 'berhasil, Pendaftaran dihentikan!');

    }

    public function show($id)
    {
        $regency = ManagementRegency::where('id',$id)->first()->toArray();

        $regencies = ProvinceRegency::all();

        // return $regency;

        return view('administration::managements.regencies.edit', compact('regency', 'regencies')); 
    }

    public function update(Request $request, $id)
    {
        $regencies = ManagementRegency::where('id',$id)->first();
        $regencies->update([
            'name' => $request->input('name'),
            'regency_id' => $request->input('regency_id'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'pimda_code' => $request->input('code'),
            'address' => $request->input('address')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function destroy(ManagementRegency $id)
    {
        $tmp = $id;
        $id->delete();

        return redirect()->back()->with('success', 'Pimda berhasil dihapus');
    }
}