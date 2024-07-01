<?php

namespace Modules\Event\Http\Requests\Manage\Event;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Str;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventType;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', Event::class);
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
            ...$this->only('title', 'description'),
            'kd' => Str::lower(str_replace(' ', '-', $this->input('title'))),
        ];
    }
}
