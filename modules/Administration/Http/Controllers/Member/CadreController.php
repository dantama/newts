<?php

namespace Modules\Administration\Http\Controllers\Member;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Modules\Administration\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use QrCode;
use PDF;
use Modules\Administration\Imports\Member\MemberImport;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserPhone;
use App\Models\UserEmail;
use App\Models\UserAddress;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\Level;
use App\Models\References\ProvinceRegency;
use App\Models\References\Employment;
use App\Models\References\Grade;

use Modules\Administration\Http\Requests\Member\StoreRequest;

class CadreController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {
        $isUserManagerRegency = auth()->user()->isManagerRegencies();

        $trashed = $request->get('trash');

        $managements = ($isUserManagerRegency)
            ? ManagementRegency::with('management')->fromCurrentManagerials()->get()
            : ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

        $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

        $selected = ($isUserManagerRegency)
            ? $mgmt->id
            : $mgmt->regencies->pluck('id')->toArray();

        $cadres = Member::with('user.address', 'regency', 'levels.detail')
            ->whereCodeIn(2)
            ->whereRegencyIn($selected)
            ->when($trashed, function ($query, $trashed) {
                return $query->onlyTrashed();
            })
            ->get();

        $members_count = Member::whereHas('levels.detail', function ($code) {
            return $code->where('code', 2);
        })->count();

        return view('administration::members.cadres.index', compact('cadres', 'managements', 'members_count'));
    }

    public function create()
    {

        $managements = ManagementProvince::all();

        $managementRegencys = ManagementRegency::all();

        $regencys = ProvinceRegency::all();

        $levels = Level::where('code', 2)->get();

        $employs = Employment::all();

        return view('administration::members.cadres.create', compact('managements', 'managementRegencys', 'regencys', 'levels', 'employs'));
    }

    public function store(StoreRequest $request)
    {
        $password = User::generatePassword();

        $member = Member::completeInsert($request, $password);

        // insert member level
        $level = new MemberLevel([
            'level_id'  => $request->input('level_id')
        ]);

        $member->levels()->save($level);

        return redirect($request->get('next', url()->previous()))->with('success', 'Kader <strong>' . $member->user->profile->name . ' (' . $member->user->username . ')</strong> berhasil dibuat dengan sandi <strong>' . $password . '</strong>');
    }

    public function destroy(Member $cadre)
    {

        // return $cadre;

        $tmp = $cadre;
        $cadre->delete();

        return redirect()->back()->with('success', 'User <strong>' . $tmp->user->profile->name . ' (' . $tmp->id . ')</strong> berhasil dihapus');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Member $cadre)
    {

        $cadre->restore();

        return redirect()->back()->with('success', 'User <strong>' . $cadre->user->profile->name . ' (' . $cadre->id . ')</strong> berhasil dipulihkan');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Member $cadre)
    {

        $tmp = $cadre;
        $cadre->forceDelete();
        return redirect()->back()->with('success', 'User <strong>' . $tmp->user->profile->name . ' (' . $tmp->id . ')</strong> berhasil dihapus permanen dari sistem');
    }

    public function show($cadre)
    {

        $cadres = Member::with('user.achievements', 'regency', 'levels.detail')->where('id', $cadre)->get();

        return view('administration::members.cadres.detail', compact('cadres'));
    }

    public function profile($cadre)
    {

        $cadres = Member::with('user')->where('id', $cadre)->get();

        $grades = Grade::all();

        $employments = Employment::all();

        if ($cadres) {
            return view('administration::members.cadres.profiles.profile', compact('cadres', 'grades', 'employments'));
        } else {
            return redirect()->back()->with('danger', '<strong>Data yang Anda cari tidak ditemukan, silakan periksa kembali data Anda</strong>');
        }
    }

    public function profileupdate(Request $request, $user)
    {

        $profile = UserProfile::where('user_id', $user)->first();

        $profile->update([
            'name'   => $request->input('name'),
            'nik'    => $request->input('nik'),
            'sex'    => $request->input('sex'),
            'dob'    => $request->input('dob'),
            'pob'    => $request->input('pob'),
            'prefix' => $request->input('prefix'),
            'suffix' => $request->input('suffix'),
            'blood'  => $request->input('blood'),
            'grade_id' => $request->input('grade_id'),
            'employment_id' => $request->input('employment_id')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function phone($cadre)
    {

        $members = Member::with('user')->where('id', $cadre)->get();

        return view('administration::members.cadres.profiles.phone', compact('members'));
    }

    public function phoneupdate(Request $request, $user)
    {

        $phone = UserPhone::updateOrCreate(
            ['user_id' => $user],
            ['number' => $request->input('phone'), 'whatsapp' => $request->input('wa')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function email($cadre)
    {

        $members = Member::with('user')->where('id', $cadre)->get();

        return view('administration::members.cadres.profiles.email', compact('members'));
    }

    public function emailupdate(Request $request, $user)
    {

        $email = UserEmail::updateOrCreate(
            ['user_id' => $user],
            ['address' => $request->input('email')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function address($cadre)
    {

        $members = Member::with('user')->where('id', $cadre)->get();

        $regencys = ProvinceRegency::all();

        return view('administration::members.cadres.profiles.address', compact('members', 'regencys'));
    }


    public function addressupdate(Request $request, $user)
    {

        $email = UserAddress::updateOrCreate(
            ['user_id' => $user],
            [
                'address'  => $request->input('address'),
                'rt'       => $request->input('rt'),
                'rw'       => $request->input('rw'),
                'village'  => $request->input('village'),
                'district_id' => $request->input('district_id'),
                'postal'   => $request->input('postal'),
            ]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function organizations($cadre)
    {

        $members = Member::with('user')->where('id', $cadre)->get();

        $managements = ManagementProvince::all();

        $managementRegencys = ManagementRegency::all();

        return view('administration::members.cadres.profiles.organization', compact('managements', 'managementRegencys', 'members'));
    }

    public function organizationupdate(Request $request, $user)
    {

        $tmp = $user;

        $cadre = Member::where('user_id', $tmp)->first();

        $cadre->update([
            'regency_id' => $request->input('mgmt_province_regencies_id'),
            'joined_at' => $request->input('joined_at')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function nbts($cadre)
    {

        $members = Member::with('user', 'regency')->where('id', $cadre)->get();

        $managements = ManagementProvince::all();

        $managementRegencys = ManagementRegency::all();

        return view('administration::members.cadres.profiles.nbts', compact('members'));
    }

    public function nbm($cadre)
    {

        $members = Member::with('user', 'regency')->where('id', $cadre)->get();

        $managements = ManagementProvince::all();

        $managementRegencys = ManagementRegency::all();

        return view('administration::members.cadres.profiles.nbm', compact('members'));
    }

    public function nbtsupdate(Request $request, $user)
    {

        $tmp = $user;

        $this->validate($request, ['nbts' => 'unique:ts_members,nbts']);

        $cadre = Member::where('user_id', $tmp)->first();

        $param = env('APP_URL') . '/finder/member-view/' . base64_encode($user);

        if (!empty($cadre->user->profile->avatar)) {

            $cadre->update([
                'nbts' => $request->input('nbts')
            ]);

            $image_name = 'qr-' . $cadre->user->username . '-' . time() . '.svg';
            $path = 'uploads/avatar/' . $tmp . '/' . $image_name;

            $qr = \QrCode::format('svg')->color(255, 0, 0)->size(200)->generate($param);

            Storage::put($path, $qr);

            $QrCode = Member::updateOrCreate(
                ['user_id' => $tmp],
                ['qr' => $path]
            );

            return redirect()->back()->with('success', 'Berhasil memperbarui data!');
        } else {

            return redirect()->back()->with('warning', 'Peringatan, data foto belum tersedia!, Anda <strong>mungkin</strong> harus mengulang lagi.');
        }
    }

    public function nbmupdate(Request $request, $user)
    {

        $tmp = $user;

        $this->validate($request, ['nbm' => 'unique:ts_members,nbm']);

        $cadre = Member::where('user_id', $tmp)->first();

        $cadre->update([
            'nbm' => $request->input('nbm')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function avatar($cadre)
    {

        $members = Member::with('user')->where('id', $cadre)->get();

        return view('administration::members.cadres.profiles.avatar', compact('members'));
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

    public function level($cadre)
    {
        $members = Member::with('user', 'levels.detail')->where('id', $cadre)->get();

        $last = MemberLevel::select('level_id')->where('member_id', $cadre)->latest('level_id')->first();

        // $levels = Level::where('id','>',$last->level_id ?? 5)->take(1)->get();
        $levels = Level::whereIn('code', array(2, 3))->get();

        return view('administration::members.cadres.profiles.level', compact('members', 'levels', 'last'));
    }

    public function levelupdate(Request $request, $cadre)
    {
        $tingkat = MemberLevel::updateOrCreate(
            ['member_id' => $cadre, 'level_id' => $request->input('level_id')],
            ['level_id' => $request->input('level_id'), 'year' => $request->input('tahun')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function importCadre(Request $request)
    {
        $request->validate([
            'file' => 'file|mimes:xlsx|max:2048',
        ]);

        try {
            $import = new MemberImport();
            $import->import($request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $message = '';

            foreach ($failures as $failure) {
                $failure->row();
                $failure->attribute();
                $failure->errors();
                $failure->values();

                $message .= '<br>' . $failure->values()['nama'] . ' : ' . $failure->errors()[0];
            }

            return redirect()->back()->with('danger', 'Error! ' . $message);
        }

        return redirect()->back()->with('success', 'Berhasil impor data!');
    }

    /**
     * Get the cadre card.
     */
    public function card($cadre)
    {
        $member = Member::with('user.achievements', 'regency', 'levels.detail')->where('id', $cadre)->firstOrFail();

        $title = 'KTA-' . $member->user->profile->name . '.pdf';

        // return view('administration::members.cadres.kta', compact('member', 'title'));

        $pdf = \PDF::loadView('administration::members.cadres.kta', compact('member', 'title'))
            ->setPaper([0, 0, 155.906, 240.945], 'landscape');

        return $pdf->stream($title);
    }

    public function downloadpdf(Request $request)
    {

        $isUserManagerRegency = auth()->user()->isManagerRegencies();

        $trashed = $request->get('trash');

        $managements = ($isUserManagerRegency)
            ? ManagementRegency::with('management')->fromCurrentManagerials()->get()
            : ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

        $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

        $selected = ($isUserManagerRegency)
            ? $mgmt->id
            : $mgmt->regencies->pluck('id')->toArray();

        $cadres = Member::with('user.address', 'regency', 'levels.detail')
            ->whereCodeIn(2)
            ->whereRegencyIn($selected)
            ->when($trashed, function ($query, $trashed) {
                return $query->onlyTrashed();
            })
            ->get();

        // return $warriors;

        $pdf = PDF::loadview('administration::members.cadres.pdf', ['members' => $cadres]);
        return $pdf->stream();
    }

    public function joined(Request $request, $cadre)
    {

        $members = Member::with('user')->whereId($cadre)->first();

        return view('administration::members.cadres.profiles.joined', compact('members'));
    }

    public function joinedupdate(Request $request, $cadre)
    {

        $phone = Member::whereId($cadre)->update(['joined_at' => $request->get('joined_at')]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function repass(User $user)
    {
        // $this->authorize('update', $user);

        if ($user->trashed()) abort(404);

        $password = $user->resetPassword();

        return redirect()->back()->with('success', 'Password <strong>' . $user->profile->name . ' (' . $user->username . ')</strong> berhasil diatur ulang menjadi <strong>' . $password . '</strong>');
    }
}
