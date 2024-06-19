<?php

namespace Modules\Event\Http\Requests\Finance\Payment;

use App\Http\Requests\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->transaction);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'code'          => 'required|string',
            'paid_amount'   => 'required|numeric|min:0',
            'paid_at'       => 'required|date',
            'method'        => 'required|in:1,2',
            'validated'     => 'nullable|boolean',
            'paid_off'      => 'nullable|boolean'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'code'          => 'kode pembayaran',
            'paid_amount'   => 'nominal',
            'paid_at'       => 'tanggal pembayaran',
            'method'        => 'metode pembayaran',
            'validated'     => 'validasi',
            'paid_off'      => 'status'
        ];
    }

    /**
     * Transform request into expected output.
     */
    public function transform()
    {
        return [
            ...$this->only('code', 'paid_amount', 'paid_at', 'method', 'paid_off'),
            'validated_at' => $this->has('validated') ? now() : null
        ];
    }
}
