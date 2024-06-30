<?php

namespace Modules\Reference\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Reference\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resources..
     */
    public function index(Request $request)
    {
        return response()->success([
            'users' => User::where('name', 'like', '%' . $request->get('q') . '%')->get()->map(fn ($v) => [
                'id' => $v->id,
                'text' => $v->name
            ])
        ]);
    }
}
