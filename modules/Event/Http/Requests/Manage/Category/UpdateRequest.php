<?php

namespace Modules\Event\Http\Requests\Manage\Category;

class UpdateRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', $this->category);
    }
}
