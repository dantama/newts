<?php

namespace Modules\Blog\Http\Requests\Article\Category;

use App\Http\Requests\FormRequest;
use Modules\Blog\Models\Category;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', Category::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title'       => 'required|max:200|string',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'title'        => 'judul',
            'description'  => 'deskripsi',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            ...$this->only('title', 'description'),
            'slug' => Str::lower(str_replace(' ', '-', $this->input('title'))),
        ];
    }
}
