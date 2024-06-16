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
use App\Models\UserPhone;
use App\Models\UserEmail;
use App\Models\UserAddress;
use App\Models\Member;
use App\Models\MemberLevel;
use App\Models\ManagementPerwil;
use App\Models\Level;
use App\Models\References\ProvinceRegency;
use App\Models\References\Employment;
use App\Models\References\Grade;

use Modules\Administration\Http\Requests\Member\StoreRequest;

class CadrePerwilController extends Controller
{

    public function index(Request $request)
    {

        $trashed = $request->get('trash');

        $managements = ManagementPerwil::fromCurrentManagerials()->get();

        $cadres = Member::isPerwil()->with('user.address', 'levels.detail')->whereCodeIn(2)->wherePerwilId($request->input('perwil', 1))
                        ->when($trashed, function($query, $trashed) { return $query->onlyTrashed(); })->get();

        $members_count = Member::whereHas('levels.detail', function($code){ return $code->where('code', 2); })->count();   

        // return $cadres;  
        
        return view('administration::members.perwil.cadre.index', compact('cadres','managements','members_count'));
    }

    public function create()
    {

        $managements = ManagementPerwil::all();
        
        $levels = Level::where('code',2)->get();
        
        $employs = Employment::all();

        return view('administration::members.perwil.cadre.create', compact('managements','managementRegencys','regencys','levels','employs'));
    }

    public function store(Request $request)
    {
        $password = User::generatePassword();

        $member = Member::completeInsertPerwil($request, $password);

        // insert member level
        $level = new MemberLevel([
            'level_id'  => $request->input('level_id')
        ]);

        $member->levels()->save($level);

        return redirect($request->get('next', url()->previous()))->with('success', 'Pendekar <strong>'.$member->user->profile->name.' ('.$member->user->username.')</strong> berhasil dibuat dengan sandi <strong>'.$password.'</strong>');
    }

    public function destroy(Member $perwil_cadres)
    {

        $tmp = $perwil_cadres;
        $perwil_cadres->delete();

        return redirect()->back()->with('success', 'User <strong>'.$tmp->user->profile->name.' ('.$tmp->id.')</strong> berhasil dihapus');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Member $perwil_cadres)
    {

        $perwil_cadres->restore();

        return redirect()->back()->with('success', 'User <strong>'.$perwil_cadres->user->profile->name.' ('.$perwil_cadres->id.')</strong> berhasil dipulihkan');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Member $perwil_cadres)
    {

        $tmp = $perwil_cadres;
        $perwil_cadres->forceDelete();
        return redirect()->back()->with('success', 'User <strong>'.$tmp->user->profile->name.' ('.$tmp->id.')</strong> berhasil dihapus permanen dari sistem');
    }

    public function show($perwil_cadres)
    {

        $cadres = Member::isPerwil()->with('user.achievements','regency','levels.detail')->where('id', $perwil_cadres)->first();

        return view('administration::members.perwil.cadre.detail', compact('cadres'));

    }

    public function profile($perwil_cadres)
    {

        $cadres = Member::isPerwil()->with('user')->where('id', $perwil_cadres)->first();

        $grades = Grade::all();
        
        $employments = Employment::all();

        if($cadres){
            return view('administration::members.perwil.cadre.profile', compact('cadres','grades','employments'));
        } else {
            return redirect()->back()->with('danger', '<strong>Data yang Anda pilih tidak ada, silakan periksa kembali data Anda</strong>');
        }

        
    }

    public function profileupdate(Request $request, $user)
    {

        $profile = UserProfile::where('user_id',$user)->first();

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

    public function phone($perwil_cadres)
    {

        $members = Member::isPerwil()->with('user')->where('id', $perwil_cadres)->first();      

        return view('administration::members.perwil.cadre.phone', compact('members'));
        
    }

    public function phoneupdate(Request $request, $user)
    {

        $phone = UserPhone::updateOrCreate(
            ['user_id' => $user],
            ['number' => $request->input('phone'),'whatsapp' => $request->input('wa')]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
        
    }

    public function email($perwil_cadres)
    {

        $members = Member::isPerwil()->with('user')->where('id',$perwil_cadres)->first();

        return view('administration::members.perwil.cadre.email', compact('members'));
        
    }

    public function emailupdate(Request $request, $user)
    {

        $email = UserEmail::updateOrCreate(
            ['user_id' => $user],
            ['address' => $request->input('email')]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
        
    }

    public function address($perwil_cadres)
    {

        $members = Member::isPerwil()->with('user')->where('id', $perwil_cadres)->first();

        $regencys = ProvinceRegency::all();

        return view('administration::members.perwil.cadre.address', compact('members','regencys'));
        
    }


    public function addressupdate(Request $request, $user)
    {

        $email = UserAddress::updateOrCreate(
            ['user_id' => $user],
            ['address'  => $request->input('address'),
            'rt'       => $request->input('rt'),
            'rw'       => $request->input('rw'),
            'village'  => $request->input('village'),
            'district_id' => $request->input('district_id', NULL),
            'postal'   => $request->input('postal'),
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
        
    }

    public function organizations($perwil_cadres)
    {

        $members = Member::isPerwil()->with('user')->where('id', $perwil_cadres)->first();

        $managements = ManagementPerwil::all();

        return view('administration::members.perwil.cadre.organization', compact('managements','managementRegencys','members'));
        
    }

    public function organizationupdate(Request $request, $user)
    {

        $tmp = $user;

        $request->validate([
            'perwil_id'  => 'required|numeric',
        ]);

        $warrior = Member::isPerwil()->where('user_id',$tmp)->first();

        $warrior->update([
            'perwil_id' => $request->input('perwil_id'),
            'joined_at' => $request->input('joined_at')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
        
    }

    public function nbts($perwil_cadres)
    {

        $members = Member::isPerwil()->with('user','perwildata')->where('id',$perwil_cadres)->first();

        $managements = ManagementPerwil::all();

        return view('administration::members.perwil.cadre.nbts', compact('members'));
        
    }

    public function nbm($perwil_cadres)
    {

        $members = Member::isPerwil()->with('user')->where('id',$perwil_cadres)->first();

        return view('administration::members.perwil.cadre.nbm', compact('members'));
        
    }

    public function nbtsupdate(Request $request, $user)
    {

        $this->validate($request, ['nbts' => 'unique:ts_members,nbts']);

        $cadre = Member::isPerwil()->with('user')->where('user_id',$user)->first();

        $param = env('APP_URL').'/finder/member-view/'.base64_encode($user);

        if(!empty($cadre->user->profile->avatar)){

            $cadre->update([
                'nbts' => $request->input('nbts')
            ]);

            $image_name = 'qr-' .$cadre->user->username. '-' .time(). '.svg';
            $path = 'uploads/avatar/'.$user.'/' . $image_name;

            $qr = \QrCode::format('svg')->color(255, 0, 0)->size(200)->generate($param);

            Storage::put($path, $qr);

            $QrCode = Member::isPerwil()->updateOrCreate(
                ['user_id' => $user],
                ['qr' => $path]
            );

            return redirect()->back()->with('success', 'Berhasil membuat QrCode!');

        } else {

            return redirect()->back()->with('warning', 'Peringatan, data foto belum tersedia!, Anda <strong>mungkin</strong> harus mengulang lagi.');

        }

    }

    public function nbmupdate(Request $request, $user)
    {

        $tmp = $user;

        $this->validate($request, ['nbm' => 'unique:ts_members,nbm']);

        $warrior = Member::isPerwil()->where('user_id',$tmp)->first();

        $warrior->update([
            'nbm' => $request->input('nbm')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
        
    }

    public function avatar($perwil_cadres)
    {

        $members = Member::isPerwil()->with('user')->where('id',$perwil_cadres)->first();

        return view('administration::members.perwil.cadre.avatar', compact('members'));
        
    }

    public function avatarupdate(Request $request)
    {
        if($request->ajax())
        {
            $user_id = $request->input('user_id');
            $image_data = $request->input('image');

            $image_array_1 = explode(";", $image_data);
            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $image_name = time() . '.png';
            $path = 'uploads/avatar/'.$user_id.'/' . $image_name;

            Storage::put($path, $data);

            $profile = UserProfile::updateOrCreate(
               ['user_id' => $user_id],
               ['avatar' => $path]
           );

            return response()->json(['path' => Storage::url($path)]);
        }
    }

    public function level($perwil_cadres)
    {
        $members = Member::isPerwil()->with('user','levels.detail')->where('id', $perwil_cadres)->first();

        $last = MemberLevel::select('level_id')->where('member_id', $perwil_cadres)->latest('level_id')->first();

        // $levels = Level::where('id','>',$last->level_id ?? 10)->take(1)->get();
        $levels = Level::whereIn('code',array(2,3))->get();

        // return $last;

        return view('administration::members.perwil.cadre.level', compact('members','levels','last'));
    }

    public function levelupdate(Request $request, $perwil_cadres)
    {
        $tingkat = MemberLevel::updateOrCreate(
            ['member_id' => $perwil_cadres, 'level_id' => $request->input('level_id') ],
            ['level_id' => $request->input('level_id'), 'year' => $request->input('tahun')]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function importwarrior(Request $request) 
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

               $message .= '<br>'.$failure->values()['nama'].' : '.$failure->errors()[0];
           }

           return redirect()->back()->with('danger', 'Error! '.$message);
       }

       return redirect()->back()->with('success', 'Berhasil impor data!');
   }

    /**
     * Get the warrior card.
     */
    public function card($perwil_cadres)
    {
        $member = Member::isPerwil()->with('user.achievements','regency','levels.detail')->where('id',$perwil_cadres)->firstOrFail();

        $title = 'KTA-'.$member->user->profile->name.'.pdf';
        $pdf = \PDF::loadView('administration::members.perwil.cadre.kta', compact('member', 'title'))
        ->setPaper([0, 0, 155.906, 240.945], 'landscape');

        // return view('administration::members.cadres.kta', compact('member','title'));
        return $pdf->stream($title);
    }

    public function downloadpdf(Request $request)
    {

        $cadres = Member::isPerwil()->with('user.address', 'levels.detail')->whereCodeIn(3)->wherePerwilId($request->get('perwil', 1))->get();

        // return $cadres;

        $pdf = PDF::loadview('administration::members.perwil.cadre.pdf',['members'=>$cadres]);
        return $pdf->stream();
    }

    public function joined(Request $request, $perwil_cadres)
    {

        $members = Member::isPerwil()->with('user')->whereId($perwil_cadres)->first();      

        return view('administration::members.perwil.cadre.joined', compact('members'));
        
    }

    public function joinedupdate(Request $request, $perwil_cadres)
    {

        $phone = Member::isPerwil()->whereId($perwil_cadres)->update(['joined_at'=> $request->get('joined_at')]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
        
    }

    public function repass(User $user)
    {
        // $this->authorize('update', $user);

        if($user->trashed()) abort(404);
        
        $password = $user->resetPassword();

        return redirect()->back()->with('success', 'Password <strong>'.$user->profile->name.' ('.$user->username.')</strong> berhasil diatur ulang menjadi <strong>'.$password.'</strong>');
    }

}