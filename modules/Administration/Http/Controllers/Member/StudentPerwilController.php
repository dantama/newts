<?php

namespace Modules\Administration\Http\Controllers\Member;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Modules\Administration\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Administration\Imports\Member\StudentImport;
use PDF;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserPhone;
use App\Models\UserEmail;
use App\Models\UserAddress;
use App\Models\Student;
use App\Models\StudentLevel;
use App\Models\UserOrganization;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\ManagementDistrict;
use App\Models\References\ProvinceRegency;
use App\Models\References\Grade;
use App\Models\Level;

class StudentPerwilController extends Controller
{
    /**
     * Display a analytical and statistical dashboard.
     */
    public function index(Request $request)
    {

        $user = auth()->user();

        $trashed = $request->get('trash');

        if (auth()->user()->isManagerDistricts()) {
            $managements = ManagementDistrict::with('management')->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->where('district_id', $mgmt->id)
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::where('district_id', $mgmt->id)->count();
        } else if (auth()->user()->isManagerRegencies()) {
            $managements = ManagementRegency::with('management')->fromCurrentManagerials()->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->where('regency_id', $mgmt->id)
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::where('regency_id', $mgmt->id)->count();
        } else if (auth()->user()->isManagerProvinces()) {
            $managements = ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->whereRegencyIn($mgmt->regencies->pluck('id')->toArray())
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::whereRegencyIn($mgmt->regencies->pluck('id')->toArray())->count();
        } else {
            $managements = ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->whereRegencyIn($mgmt->regencies->pluck('id')->toArray())
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::all()->count();
        }
        // return $managements;

        return view('administration::members.students.index', compact('students', 'managements', 'students_count'));
    }

    public function create()
    {

        $managementRegencies = ManagementRegency::all();
        $managementDistricts = ManagementDistrict::all();

        $regencies = ProvinceRegency::all();

        $levels = Level::where('code', 1)->get();

        return view('administration::members.students.create', compact('managements', 'managementRegencies', 'regencies', 'levels', 'managementDistricts'));
    }

    public function store(Request $request)
    {
        $password = User::generatePassword();

        $student = Student::completeInsert($request, $password);

        $level = new StudentLevel([
            'level_id'  => $request->input('level_id')
        ]);

        $student->levels()->save($level);

        return redirect($request->get('next', url()->previous()))->with('success', 'Siswa <strong>' . $student->user->profile->name . ' (' . $student->user->username . ')</strong> berhasil dibuat dengan sandi <strong>' . $password . '</strong>');
    }

    public function destroy(Student $student)
    {
        // $this->authorize('remove', $student);

        $tmp = $student;
        $student->delete();

        return redirect()->back()->with('success', 'Siswa <strong>' . $tmp->user->profile->name . ' (' . $tmp->id . ')</strong> berhasil dihapus');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Student $student)
    {
        // $this->authorize('delete', $student);

        $student->restore();

        return redirect()->back()->with('success', 'Siswa <strong>' . $student->user->profile->name . ' (' . $student->id . ')</strong> berhasil dipulihkan');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Student $student)
    {
        // $this->authorize('delete', $student);

        $tmp = $student;
        $student->forceDelete();

        return redirect()->back()->with('success', 'Siswa <strong>' . $tmp->user->profile->name . ' (' . $tmp->id . ')</strong> berhasil dihapus permanen dari sistem');
    }

    public function show($student)
    {

        $students = Student::with('user.achievements', 'regency', 'district', 'levels.detail')->where('id', $student)->get();

        // return $students;

        return view('administration::members.students.detail', compact('students'));
    }

    public function profile($student)
    {

        $students = Student::with('user')->where('id', $student)->get();

        $grades = Grade::all();

        return view('administration::members.students.profiles.profile', compact('students', 'grades'));
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
            'grade_id' => $request->input('grade_id')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function phone($student)
    {

        $students = Student::with('user')->where('id', $student)->get();

        return view('administration::members.students.profiles.phone', compact('students'));
    }

    public function phoneupdate(Request $request, $user)
    {

        $phone = UserPhone::updateOrCreate(
            ['user_id' => $user],
            ['number' => $request->input('phone'), 'whatsapp' => $request->input('wa')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function email($student)
    {

        $students = Student::with('user')->where('id', $student)->get();

        return view('administration::members.students.profiles.email', compact('students'));
    }

    public function emailupdate(Request $request, $user)
    {

        $email = UserEmail::updateOrCreate(
            ['user_id' => $user],
            ['address' => $request->input('email')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function address($student)
    {

        $students = Student::with('user')->where('id', $student)->get();

        $regencys = ProvinceRegency::all();

        return view('administration::members.students.profiles.address', compact('students', 'regencys'));
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

    public function organizations($student)
    {

        $students = Student::with('user')->where('id', $student)->get();

        $managements = ManagementProvince::all();

        $managementRegencys = ManagementRegency::all();

        return view('administration::members.students.profiles.organization', compact('managements', 'managementRegencys', 'students'));
    }

    public function organizationupdate(Request $request, $user)
    {

        $tmp = $user;

        $student = Student::where('user_id', $tmp)->first();

        $student->update([
            'nbts' => $request->input('nbts'),
            'regency_id' => $request->input('mgmt_province_regencies_id'),
            'joined_at' => $request->input('joined_at')
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function avatar($warrior)
    {

        $members = Student::with('user')->where('id', $warrior)->get();

        return view('administration::members.students.profiles.avatar', compact('members'));
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

    public function level($student)
    {
        $students = Student::with('user', 'levels.detail')->where('id', $student)->get();

        $last = StudentLevel::select('level_id')->where('student_id', $student)->latest('level_id')->first();

        // $levels = Level::where('id','>',$last->level_id ?? 0)->take(1)->get();
        $levels = Level::whereIn('code', array(1, 2))->get();

        return view('administration::members.students.profiles.level', compact('students', 'levels', 'last'));
    }

    public function levelupdate(Request $request, $student)
    {
        $tingkat = StudentLevel::updateOrCreate(
            ['student_id' => $student, 'level_id' => $request->input('level_id')],
            ['level_id' => $request->input('level_id'), 'year' => $request->input('tahun')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function district($student)
    {
        $managementDistricts = ManagementDistrict::all();

        $students = Student::with('user')->where('id', $student)->get();

        return view('administration::members.students.profiles.district', compact('managementDistricts', 'students'));
    }

    public function districtupdate(Request $request, $student)
    {
        $district = Student::updateOrCreate(
            ['user_id' => $student],
            ['district_id' => $request->input('district_id')]
        );

        return redirect()->back()->with('success', 'Berhasil memperbarui data!');
    }

    public function importStudent(Request $request)
    {
        $request->validate([
            'file' => 'file|mimes:xlsx|max:2048',
        ]);

        try {
            $import = new StudentImport();
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

    public function downloadpdf(Request $request)
    {

        $isUserManagerRegency = auth()->user()->isManagerRegencies();

        $trashed = $request->get('trash');

        if (auth()->user()->isManagerDistricts()) {
            $managements = ManagementDistrict::with('management')->fromCurrentManagerials()->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->where('district_id', $mgmt->id)
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::where('district_id', $mgmt->id)->count();
        } else if (auth()->user()->isManagerRegencies()) {
            $managements = ManagementRegency::with('management')->fromCurrentManagerials()->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->where('regency_id', $mgmt->id)
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::where('regency_id', $mgmt->id)->count();
        } else if (auth()->user()->isManagerProvinces()) {
            $managements = ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->whereRegencyIn($mgmt->regencies->pluck('id')->toArray())
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::whereRegencyIn($mgmt->regencies->pluck('id')->toArray())->count();
        } else {
            $managements = ManagementProvince::with('regencies')->fromCurrentManagerials()->get();

            $mgmt = $managements->where('id', $request->get('mgmt', $managements->first()->id))->first();

            $students = Student::with(['user.address', 'regency', 'levels.detail', 'levels' => function ($level) {
                return $level->orderByDesc('level_id');
            }])->whereRegencyIn($mgmt->regencies->pluck('id')->toArray())
                ->when($trashed, function ($query, $trashed) {
                    return $query->onlyTrashed();
                })->get();

            $students_count = Student::all()->count();
        }

        // return $warriors;

        $pdf = PDF::loadview('administration::members.students.pdf', ['members' => $students]);
        return $pdf->stream();
    }

    public function repass(User $user)
    {
        // $this->authorize('update', $user);

        if ($user->trashed()) abort(404);

        $password = $user->resetPassword();

        return redirect()->back()->with('success', 'Password <strong>' . $user->profile->name . ' (' . $user->username . ')</strong> berhasil diatur ulang menjadi <strong>' . $password . '</strong>');
    }
}
