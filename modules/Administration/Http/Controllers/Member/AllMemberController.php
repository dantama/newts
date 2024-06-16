<?php

namespace Modules\Administration\Http\Controllers\Member;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Modules\Administration\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use QrCode;
use PDF;
use Modules\Administration\Imports\Member\MemberImport;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\Level;
use App\Models\References\ProvinceRegency;
use App\Models\References\Employment;
use App\Models\References\Grade;

use Modules\Administration\Http\Requests\Member\StoreRequest;

class AllMemberController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {
        $isUserManagerRegency = auth()->user()->isManagerRegencies();

        $trashed = $request->get('trash');

        $warriors = Member::with('user.address', 'regency', 'levels')
            ->when($trashed, function ($query, $trashed) {
                return $query->onlyTrashed();
            })->when($request->get('search'), function ($query, $v) {
                return $query->whereHas('user.profile', function ($profile) use ($v) {
                    $profile->where('name', 'like', '%' . $v . '%');
                });
            })->paginate($request->get('limit', 10));

        $warriors->getCollection()->transform(function ($item) {
            return [
                'id' => $item->user->id,
                'name' => $item->user->profile->name,
                'address' => $item->user->address->branch,
                'avatar' => $item->user->profile->avatar_path,
                'email' => $item->user->email->address,
                'phone' => $item->user->phone->number,
                'username' => $item->user->username,
                'uid' => $item->id,
                'level' => $item->levels->last()->detail->name,
                'level_id' => $item->levels->last()->detail->id,
                'regency_name' => $item->regency->name,
                'regency_id' => $item->regency->id,
                'nbts' => $item->nbts,
            ];
        })->toArray();

        $managements = ManagementRegency::all();

        // return $warriors;  

        return view('administration::members.all.index', compact('warriors', 'managements'));
    }


    /*
     * create disabled
     */
    public function create()
    {
        return abort(404);
    }

    /*
     * store disabled
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /*
     * show disabled
     */
    public function show($account)
    {
        $members = Member::with('user.achievements', 'regency', 'levels.detail')->where('id', $account)->first();

        // return $members;

        if ($members) {
            return view('administration::members.all.detail', compact('members'));
        } else {
            return abort(404);
        }
    }

    /*
     * Update user regency
     */
    public function update(Request $request)
    {

        if ($request->ajax()) {

            $data = json_decode($request->getContent(), true);

            $user_id      = $data['user_id'];
            $regency_id   = $data['regency_id'];

            $members = Member::updateOrCreate(
                ['user_id' => $user_id],
                ['regency_id' => $regency_id]
            );

            $response = [
                'status' => '200'
            ];

            return response()->json($response);
        }
    }

    /*
     * Kill
     */
    public function kill(Member $account)
    {

        $tmp = $account;
        $account->delete();

        return redirect()->back()->with('success', 'User <strong>' . $tmp->user->profile->name . ' (' . $tmp->id . ')</strong> berhasil dihapus');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Member $account)
    {

        $account->restore();

        return redirect()->back()->with('success', 'User <strong>' . $account->user->profile->name . ' (' . $account->id . ')</strong> berhasil dipulihkan');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function destroy(Member $account)
    {

        $tmp = $account;
        $account->forceDelete();
        return redirect()->back()->with('success', 'User <strong>' . $tmp->user->profile->name . ' (' . $tmp->id . ')</strong> berhasil dihapus permanen dari sistem');
    }

    public function avatar($account)
    {

        $members = Member::with('user')->where('id', $account)->get();

        return view('administration::members.all.profile.avatar', compact('members'));
    }

    public function avatarupdate(Request $request)
    {
        if ($request->ajax()) {
            $user_id = $request->input('user_id');
            $image_data = $request->input('image');

            $image_array_1 = explode(";", $image_data);
            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $image_name = time() . '.png';
            $path = 'uploads/avatar/' . $user_id . '/' . $image_name;

            Storage::put($path, $data);

            $profile = UserProfile::updateOrCreate(
                ['user_id' => $user_id],
                ['avatar' => $path]
            );

            return response()->json(['path' => Storage::url($path)]);
        }
    }
}
