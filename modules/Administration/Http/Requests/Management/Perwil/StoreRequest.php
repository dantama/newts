<?php

namespace Modules\Administration\Http\Requests\Management\Perwil;

use Illuminate\Foundation\Http\FormRequest;

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
            'email'         => 'required|email|max:191',
            'phone'         => 'required|numeric',
            'address'       => 'required|string|max:191',
            'code'          => 'required|string|max:191',
            'country'       => 'required|string|max:191',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'          => 'nama',
            'email'         => 'email',
            'phone'         => 'no telp',
            'address'       => 'alamat',
            'code'          => 'kode wilayah',
            'country'       => 'negara',
        ];
    }
}