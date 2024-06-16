<?php

namespace Modules\Administration\Http\Requests\Blog\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'file'          => 'nullable|file|image|max:1024',
            'categories'    => 'required|exists:blog_categories,id',
            'author_id'     => 'nullable|exists:users,id',
            'title'         => 'required|string|max:191',
            'content'       => 'required|string',
            'commentable'   => 'boolean',
            'published_at'  => 'nullable|date:Y-m-d',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'file'          => 'cover',
            'categories'    => 'kategori',
            'author_id'     => 'penulis',
            'title'         => 'judul postingan',
            'content'       => 'isi postingan',
            'commentable'   => 'fitur komentar',
            'published_at'  => 'waktu publish',
        ];
    }
}