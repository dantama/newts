<?php

namespace Modules\Reference\Http\Controllers\API;

use App\Enums\PaymentStatusEnum;
use Illuminate\Http\Request;
use Modules\Account\Models\User;
use Modules\Finance\Models\InvoiceTransaction;
use Modules\Reference\Http\Controllers\Controller;
use Modules\Reference\Services\CallbackService;
use Modules\Account\Notifications\Payment\UserPaymentNotification;
use Modules\Admin\Notifications\Payment\AdminPaymentNotification;

class PaymentController extends Controller
{
    public function getNotification(Request $request)
    {
        $callback = new CallbackService;

        $invoice = $callback->getInvoice();

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $invoice = $callback->getInvoice();

            if ($callback->isSuccess()) {

                if (is_null($invoice->paid_off_at)) {
                    $invoice->fill(['paid_off_at' => now(), 'status' => PaymentStatusEnum::SUCCESS]);
                    $invoice->save();
                }

                $transaction = InvoiceTransaction::firstWhere('invoice_id', $invoice->id);
                $transaction->fill(['validated_at' => now(), 'paid_at' => now()]);

                if ($transaction->save()) {
                    $invoice->user->notify(new UserPaymentNotification($invoice));

                    User::find(setting('cmp_admin_invoice'))->notify(new AdminPaymentNotification($invoice));

                    return response()->success([
                        'message' => 'Berhasil mengirimkan notifikasi ke user.',
                        'status' => 200
                    ]);
                }
            }

            if ($callback->isExpire()) {
                $invoice->update(['status' => PaymentStatusEnum::EXPIRE]);
            }

            if ($callback->isCancelled()) {
                $invoice->update(['status' => PaymentStatusEnum::CANCEL]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil diproses',
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Signature key tidak terverifikasi',
            ], 403);
        }
    }
}
