<?php

namespace Modules\Event\Repositories;

use Auth;
use Illuminate\Support\Arr;
use Modules\Event\Models\Invoice;
use Modules\Event\Models\InvoiceTransaction;

trait InvoiceTransactionRepository
{
    /**
     * Store newly created resource.
     */
    public function storeInvoiceTransaction(array $data)
    {
        if ($invoice = Invoice::find($data['invoice_id'])) {
            $transaction = new InvoiceTransaction($data);
            $invoice->transactions()->save($transaction);

            Auth::user()->log('membuat pembayaran invoice dengan kode invoice ' . $invoice->name . ' <strong>[ID: ' . $invoice->id . ']</strong>', InvoiceTransaction::class, $transaction->id);
            return $transaction;
        }
        return false;
    }

    /**
     * Update a resource.
     */
    public function updateInvoiceTransaction(InvoiceTransaction $transaction, array $data)
    {
        $newData = $transaction->fill($data);
        if ($newData->save()) {
            Auth::user()->log('memperbarui pembayaran dengan kode invoice' . $transaction->invoice->name . ' <strong>[ID: ' . $transaction->invoice->id . ']</strong>', InvoiceTransaction::class, $transaction->id);
            return $transaction;
        }
        return false;
    }

    /**
     * Remove the current resource.
     */
    public function removeInvoiceTransaction(InvoiceTransaction $transaction)
    {
        if (!$transaction->trashed() && $transaction->delete()) {
            Auth::user()->log('membuang pembayaran invoice dengan kode ' . $transaction->code . ' <strong>[ID: ' . $transaction->id . ']</strong>', InvoiceTransaction::class, $transaction->id);
            return $transaction;
        }
        return false;
    }
}
