<?php

namespace Modules\Account\Http\Requests\User\Profile;

use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Account\Models\User;
use Modules\Reference\Models\Country;
use Modules\Reference\Models\Timezone;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'email_address' => 'required|email|unique:' . (new User())->getTable() . ',email_address,' . $this->user()->id,
            'contact_number' => 'required|numeric',
            'contact_skype' => 'nullable|string',
            'timezone' => 'required|exists:' . (new Timezone())->getTable() . ',timezone',
            'supplier_category' => 'required|in:' . implode(',', array_keys(config('modules.account.freelancers.supplier_categories'))),
            'supplier_category_status' => [Rule::requiredIf($this->input('supplier_category') == 3)],
            'supplier_category_status.*' => 'in:business_license,physical_office',
            'address_primary' => 'required|max:180',
            'address_secondary' => 'nullable|max:180',
            'address_city' => 'required|max:180',
            'address_country' => 'required|exists:' . (new Country())->getTable() . ',id',
            'address_postal' => 'required|numeric|digits:5',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name' => 'full name',
            'email_address' => 'email address',
            'contact_number' => 'contact number',
            'contact_skype' => 'contact skype',
            'timezone' => 'timezone',
            'supplier_category' => 'supplier category',
            'supplier_category_status.*' => 'supplier category status',
            'address_primary' => 'address line 1',
            'address_secondary' => 'address line 2',
            'address_city' => 'city',
            'address_country' => 'country',
            'address_postal' => 'ZIP/postcode',
        ];
    }

    /**
     * Transform request data into expected output.
     */
    public function transform()
    {
        return [
            ...$this->only('name', 'email_address'),
            'meta' => $this->only('contact_number', 'contact_skype', 'timezone', 'supplier_category', 'supplier_category_status', 'address_primary', 'address_secondary', 'address_city', 'address_country', 'address_postal')
        ];
    }
}
