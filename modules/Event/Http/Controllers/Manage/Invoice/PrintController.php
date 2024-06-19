<?php

namespace Modules\Admin\Http\Controllers\Finance\Invoice;

use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Event\Http\Controllers\Controller;
use Modules\Event\Models\Invoice;

class PrintController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($invoice)
    {
        $this->authorize('access', Invoice::class);

        $invoice = Invoice::with('user', 'items.itemable')->whereCode($invoice)->firstOrFail();

        return Pdf::setPaper('A5', 'landscape')->loadView('admin::finance.invoices.print.show', compact('invoice'))->stream();
    }
}
