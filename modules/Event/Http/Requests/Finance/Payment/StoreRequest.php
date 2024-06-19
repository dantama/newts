<?php

namespace Modules\Event\Http\Requests\Finance\Payment;

use App\Http\Requests\FormRequest;
use Modules\Event\Models\Invoice;
use Modules\Event\Models\InvoiceTransaction;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()->can('store', InvoiceTransaction::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'invoice_id'    => 'required|exists:' . (new Invoice())->getTable() . ',id',
            'code'          => 'required|string',
            'paid_amount'   => 'required|numeric|min:0',
            'payer'         => 'required|string',
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
            'invoice_id'    => 'nominal',
            'paid_amount'   => 'nominal',
            'payer'         => 'nama',
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
            ...$this->only('invoice_id', 'code', 'paid_amount', 'payer', 'paid_at', 'method'),
            'validated_at' => $this->has('validated') ? now() : null
        ];
    }
}
