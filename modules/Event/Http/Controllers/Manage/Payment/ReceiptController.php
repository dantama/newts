<?php

namespace Modules\Admin\Http\Controllers\Finance\Payment;

use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Event\Http\Controllers\Controller;
use Modules\Event\Models\InvoiceTransaction;

class ReceiptController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(InvoiceTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        return Pdf::setPaper('A5', 'landscape')->loadView('admin::finance.payments.print.show', compact('transaction'))->stream();
    }
}
