<?php

namespace Modules\Core\Http\Controllers\Membership;

use Illuminate\Http\Request;
use Modules\Core\Enums\MembershipTypeEnum;
use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Models\Member;
use Modules\Reference\Models\Province;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Modules\Core\Repositories\UnitRepository;

class MemberController extends Controller
{
    use UnitRepository;
    /**
     * display all resource page.
     */
    public function index(Request $request)
    {
        $memberships = collect(MembershipTypeEnum::cases());

        $units = Unit::with('parents.parents', 'meta')->get();

        $param = $request->get('unit') ? $this->transformUnit(Unit::find($request->get('unit'))) : '';

        $data = Member::with('user', 'unit', 'level', 'meta')
            ->search($request->get('search'))
            ->whenUnits($param)
            ->whenType($request->get('membership'))
            ->whenTrashed($request->get('trash'))
            ->get();

        $totalGroup = count($data);
        $perPage    = $request->get('limit', 10);
        $page       = Paginator::resolveCurrentPage('page');

        $members = new LengthAwarePaginator($data->forPage($page, $perPage), $totalGroup, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        $member_count = $totalGroup;

        return view('core::membership.members.index', compact('members', 'member_count', 'memberships', 'units'));
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
