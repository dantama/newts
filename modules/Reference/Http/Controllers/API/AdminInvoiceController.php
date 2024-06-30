<?php

namespace Modules\Reference\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Reference\Http\Controllers\Controller;

class AdminInvoiceController extends Controller
{
    /**
     * Set admin for pretest.
     */
    public function store(Request $request)
    {
        if ($request->input('user_id')) {
            setting_set('cmp_admin_invoice', $request->input('user_id'));
        }
        return response()->success([
            'message' => 'Admin invoice berhasil disimpan',
        ]);
    }
}
