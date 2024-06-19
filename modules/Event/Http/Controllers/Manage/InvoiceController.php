<?php

namespace Modules\Event\Http\Controllers\Manage;

use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Event\Http\Controllers\Controller;
use Modules\Event\Http\Requests\Finance\Invoice\StoreRequest;
use Modules\Event\Http\Requests\Finance\Invoice\UpdateRequest;
use Modules\Event\Models\Event;
use Modules\Event\Models\Invoice;
use Modules\Event\Repositories\InvoiceRepository;

class InvoiceController extends Controller
{
    use InvoiceRepository;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', Invoice::class);

        $invoices = Invoice::with('user', 'transactions')->withCount('items')
            ->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->latest()
            ->paginate($request->get('limit', 10));

        $invoices_count = Invoice::count();

        return view('admin::finance.invoices.index', compact('invoices', 'invoices_count'));
    }

    /**
     * Display create resource page.
     */
    public function create()
    {
        $this->authorize('store', Invoice::class);

        $users = User::orderBy('name')->get();
        $itemables = [
            'Event' => Event::all(),
        ];

        return view('admin::finance.invoices.create', compact('users', 'itemables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($invoice = $this->storeInvoiceWithItems($request->transformed()->toArray())) {
            return redirect()->next()->with('success', 'Invoice dengan kode <strong>' . $invoice->code . '</strong> berhasil dibuat');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $users = User::orderBy('name')->get();
        $itemables = [
            'Event' => Event::all(),
        ];

        $invoice->load('user', 'items.itemable');

        return view('admin::finance.invoices.show', compact('users', 'invoice', 'itemables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        if ($invoice = $this->updateInvoiceWithItems($invoice, $request->transformed()->toArray())) {
            return redirect()->next()->with('success', 'Invoice dengan kode <strong>' . $invoice->code . '</strong> berhasil diperbarui');
        }
        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('destroy', $invoice);
        if ($invoice = $this->removeInvoice($invoice)) {
            return redirect()->next()->with('success', 'Invoice dengan kode <strong>' . $invoice->code . '</strong> berhasil dihapus');
        }
        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Invoice $invoice)
    {
        $this->authorize('restore', $invoice);
        if ($invoice = $this->restoreInvoice($invoice)) {
            return redirect()->next()->with('success', 'Invoice dengan kode <strong>' . $invoice->code . '</strong> berhasil dipulihkan');
        }
        return redirect()->fail();
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Invoice $invoice)
    {
        $this->authorize('restore', $invoice);
        if ($invoice = $this->killInvoice($invoice)) {
            return redirect()->next()->with('success', 'Invoice dengan kode <strong>' . $invoice->code . '</strong> berhasil dihapus permanen dari sistem');
        }
        return redirect()->fail();
    }
}
