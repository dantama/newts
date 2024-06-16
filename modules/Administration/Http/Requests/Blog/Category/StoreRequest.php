<?php

namespace Modules\Administration\Http\Requests\Blog\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // return auth()->user()->can('update', auth()->user());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:191',
            'description'   => 'nullable|string|max:191',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'          => 'nama kategori',
            'description'   => 'deskripsi',
        ];
    }
}