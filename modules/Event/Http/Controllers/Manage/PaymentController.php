<?php

namespace Modules\Event\Http\Controllers\Finance;

use Illuminate\Http\Request;
use Modules\Event\Http\Controllers\Controller;
use Modules\Event\Http\Requests\Finance\Payment\StoreRequest;
use Modules\Event\Http\Requests\Finance\Payment\UpdateRequest;
use Modules\Event\Notifications\Payment\UserValidationNotification;
use Modules\Event\Models\Invoice;
use Modules\Event\Models\InvoiceTransaction;
use Modules\Event\Repositories\InvoiceTransactionRepository;

class PaymentController extends Controller
{
    use InvoiceTransactionRepository;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', InvoiceTransaction::class);

        $transactions = InvoiceTransaction::with('invoice.user')
            ->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->latest()
            ->paginate($request->get('limit', 10));

        $transactions_count = InvoiceTransaction::count();

        return view('admin::finance.payments.index', compact('transactions', 'transactions_count'));
    }

    /**
     * Display create resource page.
     */
    public function create(Request $request)
    {
        $this->authorize('store', InvoiceTransaction::class);

        $invoices = Invoice::with('user')->whereNull('paid_off_at')->get();
        $invoice = Invoice::with('items', 'transactions')->whereNull('paid_off_at')->whereCode($request->get("invoice"))->first();

        return view('admin::finance.payments.create', compact('invoices', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($transaction = $this->storeInvoiceTransaction($request->transformed()->toArray())) {
            if ($request->has('paid_off')) {
                $transaction->invoice->update(['paid_off_at' => now()]);
            }
            $invoice = $transaction->invoice;
            $invoice->user->notify(new UserValidationNotification($invoice));
            return redirect()->next()->with('success', 'Pembayaran dengan ID: <strong>' . $transaction->id . '</strong> berhasil dibuat');
        }
        return redirect()->fail();
    }

    /**
     * Edit resource page.
     */
    public function edit(InvoiceTransaction $transaction, Request $request)
    {
        $this->authorize('store', InvoiceTransaction::class);

        return view('admin::finance.payments.edit', compact('transaction'));
    }

    /**
     * Update a resource in storage.
     */
    public function update(InvoiceTransaction $transaction, UpdateRequest $request)
    {
        if ($transaction = $this->updateInvoiceTransaction($transaction, $request->transformed()->toArray())) {
            if ($request->has('paid_off')) {
                $transaction->invoice->update(['paid_off_at' => now()]);
            }
            return redirect()->next()->with('success', 'Pembayaran dengan ID: <strong>' . $transaction->id . '</strong> berhasil diperbarui');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        return 'PDF';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceTransaction $transaction)
    {
        $this->authorize('destroy', $transaction);
        if ($transaction = $this->removeInvoiceTransaction($transaction)) {
            return redirect()->next()->with('success', 'Pembayaran dengan ID: <strong>' . $transaction->id . '</strong> berhasil dihapus');
        }
        return redirect()->fail();
    }
}
