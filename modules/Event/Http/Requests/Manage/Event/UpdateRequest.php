<?php

namespace Modules\Event\Http\Requests\Manage\Event;

class UpdateRequest extends StoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', $this->event);
    }
}
