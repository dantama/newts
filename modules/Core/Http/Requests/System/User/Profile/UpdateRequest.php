<?php

namespace Modules\Core\Http\Requests\System\User\Profile;

use Modules\Account\Http\Requests\User\Profile\UpdateRequest as FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->user);
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function rules()
    {
        return [
            'name'              => 'required',
            'email_address'     => 'required',
            'address_primary'   => 'nullable',
            'address_secondary' => 'nullable',
            'address_city'      => 'nullable',
            'address_postal'    => 'nullable',
            'contact_number'    => 'required'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'              => 'nama lengkap',
            'email_address'     => 'alamat surel',
            'address_primary'   => 'alamat utama',
            'address_secondary' => 'alamat tambahan',
            'address_city'      => 'kota',
            'address_postal'    => 'kode pos',
            'contact_number'    => 'nomor kontak'
        ];
    }

    /**
     * Transform request data into expected output.
     */
    public function transform()
    {
        return [
            ...$this->only('name', 'email_address'),
            'meta' => [
                ...$this->only('address_primary', 'address_secondary', 'address_city', 'address_postal', 'contact_number')
            ]
        ];
    }
}
