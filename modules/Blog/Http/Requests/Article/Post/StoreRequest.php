<?php

namespace Modules\Blog\Http\Requests\Article\Post;

use App\Http\Requests\FormRequest;
use Modules\Blog\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Enums\VisibilityTypeEnum;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', Post::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'title'    => 'required|max:250|string',
            'content'  => 'required|string',
            'meta.*'   => 'nullable',
            'ctg_id.*' => 'nullable',
            'tags.*'   => 'nullable',
            'file'     => 'nullable',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'title'    => 'judul',
            'content'  => 'isi artikel',
            'meta.*'   => 'meta',
            'ctg_id.*' => 'kategori',
            'tags.*'   => 'tags',
            'file'     => 'cover',
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $meta = array_merge([
            'poster_file' => !empty($this->input('file')) ? json_decode($this->input('file'))->path : ''
        ], $this->input('meta'));

        return [
            ...$this->only('title', 'content',),
            'slug' => Str::lower(str_replace(' ', '-', $this->input('title'))),
            'author_id' => Auth::user()->id,
            'type' => !is_null($this->input('is_draft')) ? VisibilityTypeEnum::PRIVATE->value : VisibilityTypeEnum::PUBLIC->value,
            'published_at' => !is_null($this->input('is_draft')) ? null : now(),
            'meta' => $meta,
            'category' => $this->input('ctg_id'),
            'tags' => $this->input('tags')
        ];
    }
}
