<?php

namespace Modules\Blog\Http\Requests\Pages;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Models\Template;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', Template::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title'    => 'required|max:200|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'title'    => 'judul',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {

        return [
            ...$this->only('title'),
            'author_id' => Auth::user()->id,
            'slug' => Str::lower(str_replace(' ', '-', $this->input('title'))),
            'content' => '<h1>Silakan buat desain di sini!</h1>',
        ];
    }
}
