<?php

namespace Modules\Administration\Http\Requests\Management\Regency;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'regency_id'    => 'required|unique:ts_mgmt_regencies,regency_id|exists:ref_province_regencies,id',
            'name'          => 'required|string|max:191',
            'email'         => 'required|email|max:191',
            'phone'         => 'required|numeric',
            'address'       => 'required|string|max:191',
            'code'          => 'required|string|max:191',
            'district_id'   => 'required|exists:ref_province_regency_districts,id'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'regency_id'    => 'Kabupaten',
            'name'          => 'nama',
            'email'         => 'email',
            'phone'         => 'no telp',
            'address'       => 'alamat',
            'code'          => 'kode wilayah',
            'district_id'   => 'kecamatan',
        ];
    }
}