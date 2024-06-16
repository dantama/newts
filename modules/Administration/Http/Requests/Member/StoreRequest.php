<?php

namespace Modules\Administration\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserProfile;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:191',
            'username'      => 'required|string|max:191',
            'email'         => 'required|email|max:191',
            'phone'         => 'required|numeric',
            'address'       => 'required|string|max:191',
            'nik'           => 'required|numeric',
            'pob'           => 'required|string|max:191',
            'dob'           => 'required|string',
            'sex'           => 'required|in:'.join(',', array_keys(UserProfile::$sex)),
            'district_id'   => 'required|exists:ref_province_regency_districts,id',
            'level_id'      => 'required|numeric',
            'joined_at'     => 'required|numeric',
            'mgmt_province_id'=> 'required|exists:ts_mgmt_provinces,id',
            'mgmt_province_regencies_id'=> 'required|exists:ts_mgmt_regencies,id',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'          => 'nama',
            'name'          => 'username',
            'email'         => 'email',
            'phone'         => 'no telp',
            'address'       => 'alamat',
            'nik'           => 'NIK',
            'pob'           => 'tempat lahir',
            'dob'           => 'tanggal lahir',
            'sex'           => 'jenis kelamin',
            'district_id'   => 'kecamatan',
            'level_id'      => 'tingkat',
            'joined_at'     => 'tahun masuk',
            'mgmt_province_id' => 'pimwil',
            'mgmt_province_regencies_id' => 'pimda',
        ];
    }
}