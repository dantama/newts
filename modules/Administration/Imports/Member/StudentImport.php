<?php

namespace Modules\Administration\Imports\Member;

use App\Models\User;
use App\Models\Student;
use App\Models\ManagementRegency;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements OnEachRow, WithHeadingRow, WithValidation
{
	use Importable;

    public function onRow(Row $row)
    {
    	$rowIndex = $row->getIndex();
        $row      = $row->toArray();

    	Student::completeInsertViaImport($row);
    }

    public function rules(): array
    {
        $user = auth()->user();
        $regencies = [];
        $districts = [];

        if($user->isManagerProvinces()) {
            $province = $user->getManagementProvinces()->first()->load("regencies.districts");
            $regencies = $province->regencies->pluck('id')->join(',');
            $districts = $province->regencies->pluck('districts')->flatten()->pluck('id')->join(',');
        } else if($user->isManagerRegencies()) {
            $regency = $user->getManagementRegencies()->first()->load("districts");
            $regencies = $regency->id;
            $districts = $province->districts->pluck('id')->join(',');
        } else if($user->isManagerDistricts()) {
            $district = $user->getManagementDistricts()->first();
            $regencies = $regency->mgmt_regency_id;
            $districts = $district->id;
        } else {
        	$all = ManagementRegency::with('districts')->get();
        	$regencies = $all->pluck('id')->join(',');
        	$districts = $all->pluck('districts')->flatten()->pluck('id')->join(',');
        }

        return [
            'jenis_kelamin' => Rule::in(['0', '1']),
            'tgl_lahir' => function ($attribute, $value, $onFailure) {
            	if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $value)) {
            	    $onFailure('Isian tgl_lahir tidak valid');
            	}
            },
            'pimda' => Rule::in(explode(',', $regencies)),
            //'cabang' => Rule::in(explode(',', $districts)),
        ];
    }
}
