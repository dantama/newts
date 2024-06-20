<?php

namespace Modules\Core\Http\Controllers\Membership;

use Illuminate\Http\Request;
use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Member;
use Modules\Reference\Models\Province;

class MemberController extends Controller
{
    /**
     * display all resource page.
     */
    public function index(Request $request)
    {
        $members = Member::with('user', 'unit', 'level', 'meta')
            ->search($request->get('search'))
            ->whenUnit($request->get('unit'))
            ->whenTrashed($request->get('trash'))
            ->paginate($request->get('limit', 10));

        $member_count = Member::count();

        return view('core::membership.members.index', compact('members', 'member_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('store', Unit::class);
        $types = collect(OrganizationTypeEnum::cases());
        $provinces = Province::all();

        return view('core::membership.members.create', compact('types', 'provinces'));
    }

    /**
     * store a new resource.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Show a resource.
     */
    public function show(Unit $unit, Request $request)
    {
        $this->authorize('update', $unit);
        $unit->load('parents', 'meta');
        $types = collect(OrganizationTypeEnum::cases());

        return view('core::membership.members.show', compact('types', 'unit'));
    }
}
