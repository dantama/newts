<?php

namespace Modules\Event\Repositories;

use Auth;
use Illuminate\Support\Arr;
use Modules\Event\Models\Invoice;

trait InvoiceRepository
{
    /**
     * Store newly created resource.
     */
    public function storeInvoiceWithItems(array $data)
    {
        $invoice = new Invoice([
            'code' => 'INV' . time(),
            ...Arr::only($data, ['user_id', 'due_at', 'final_price'])
        ]);
        if ($invoice->save()) {

            $invoice->items()->createMany($data['items']);

            Auth::user()->log('membuat invoice dengan itemnya dengan kode ' . $invoice->name . ' <strong>[ID: ' . $invoice->id . ']</strong>', Invoice::class, $invoice->id);
            return $invoice;
        }
        return false;
    }

    /**
     * Store newly created resource.
     */
    public function updateInvoiceWithItems(Invoice $invoice, array $data)
    {
        $invoice->fill(Arr::only($data, ['due_at', 'final_price']));
        if ($invoice->save()) {
            $invoice->items()->delete();
            $invoice->items()->createMany($data['items']);

            Auth::user()->log('memperbarui invoice dengan itemnya dengan kode ' . $invoice->name . ' <strong>[ID: ' . $invoice->id . ']</strong>', Invoice::class, $invoice->id);
            return $invoice;
        }
        return false;
    }

    /**
     * Remove the current resource.
     */
    public function removeInvoice(Invoice $invoice)
    {
        if (!$invoice->trashed() && $invoice->delete()) {
            Auth::user()->log('membuang invoice dengan kode ' . $invoice->code . ' <strong>[ID: ' . $invoice->id . ']</strong>', Invoice::class, $invoice->id);
            return $invoice;
        }
        return false;
    }

    /**
     * Restore the current resource.
     */
    public function restoreInvoice(Invoice $invoice)
    {
        if ($invoice->trashed() && $invoice->restore()) {
            Auth::user()->log('memulihkan invoice dengan kode ' . $invoice->code . ' <strong>[ID: ' . $invoice->id . ']</strong>', Invoice::class, $invoice->id);
            return $invoice;
        }
        return false;
    }

    /**
     * Kill current resource.
     */
    public function killInvoice(Invoice $invoice)
    {
        if ($invoice->trashed() && $invoice->forceDelete()) {
            Auth::user()->log('menghapus permanen invoice dengan kode ' . $invoice->code . ' <strong>[ID: ' . $invoice->id . ']</strong>', Invoice::class, $invoice->id);
            return $invoice;
        }
        return false;
    }
}
