<?php

namespace Modules\Event\Http\Requests\Finance\Invoice;

use App\Http\Requests\FormRequest;
use Modules\Account\Models\User;
use Modules\Event\Models\Event;
use Modules\Event\Models\Invoice;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', Invoice::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'code'          => 'required|max:20|string',
            'user_id'       => 'required|exists:' . (new User())->getTable() . ',id',
            'due_at'        => 'nullable|date',
            'final_price'   => 'required|numeric|min:0',
            'items'         => 'array',
            'items.*.itemable_type' => 'required|in:Kursus,Workshop',
            'items.*.itemable_id' => 'required|numeric|min:0',
            'items.*.price' => 'required|numeric|min:0'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'code'          => 'no invoice',
            'user_id'       => 'nama',
            'due_at'        => 'tenggat',
            'final_price'   => 'total',
            'items'         => 'item',
            'items.*.itemable_type' => 'jenis item',
            'items.*.itemable_id' => 'nama item',
            'items.*.price' => 'harga'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        $items = [];
        foreach ($this->input('items') as $item) {
            $items[] = array_merge(
                $item,
                [
                    'itemable_type' => match ($item['itemable_type']) {
                        'Event' => Event::class,
                        default => Event::class
                    }
                ]
            );
        }

        return array_merge($this->only('code', 'user_id', 'due_at', 'final_price'), [
            'items' => $items
        ]);
    }
}
