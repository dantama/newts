<?php

namespace Modules\Blog\Http\Requests\Testimony;

use App\Http\Requests\FormRequest;
use Modules\Blog\Models\Testimony;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // return $this->user()->can('store', Testimony::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'    => 'required|max:200|string',
            'content' => 'nullable|string',
            'file'    => 'nullable',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name'    => 'judul',
            'content' => 'deskripsi',
            'file'    => 'file',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {

        return [
            ...$this->only('name', 'content'),
            'meta' => [
                'avatar' => $this->input('file')
            ],
        ];
    }
}
