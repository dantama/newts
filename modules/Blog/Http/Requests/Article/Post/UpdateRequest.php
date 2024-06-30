<?php

namespace Modules\Blog\Http\Requests\Article\Post;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Modules\Blog\Enums\VisibilityTypeEnum;

class UpdateRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->post);
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
