<?php

namespace Modules\Administration\Http\Controllers\Management\Perwil;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

use App\Models\Manager;
use App\Models\ManagementPerwil;

use Modules\Administration\Http\Requests\Management\Perwil\StoreRequest;

class PerwilController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index()
    {
        $managements = ManagementPerwil::fromCurrentManagerials()->get();

        $managements_count = ManagementPerwil::count();
        $managers_count = Manager::inPerwil()->count();

        // return $managements;

        return view('administration::managements.perwils.index', compact('managements', 'managements_count', 'managers_count'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        //return dd($data);

        $mgmt_province = new ManagementPerwil([
            'mgmt_id' => 1,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'perwil_code' => $request->input('code'),
            'address' => $request->input('address'),
        ]);

        $mgmt_province->save();

        return redirect($request->get('next', route('administration::managements.perwil.index')))->with('success', 'berhasil');
    }

    public function show($perwil)
    {
        $perwil = ManagementPerwil::where('id', $perwil)->first();

        return view('administration::managements.perwils.edit', compact('perwil'));
    }

    public function update(Request $request, $perwil)
    {
        $perwil = ManagementPerwil::find($perwil);
        $perwil->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'perwil_code' => $request->input('code'),
            'address' => $request->input('address')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }
}
