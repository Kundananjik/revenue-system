<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PaymentObserver
{
    /**
     * Handle events after a payment is created.
     */
    public function created(Payment $payment)
    {
        $this->log('created', $payment);
    }

    /**
     * Handle events after a payment is updated.
     */
    public function updated(Payment $payment)
    {
        $this->log('updated', $payment);
    }

    /**
     * Handle events after a payment is deleted.
     */
    public function deleted(Payment $payment)
    {
        $this->log('deleted', $payment);
    }

    /**
     * Generic log function
     */
    protected function log(string $action, Payment $payment)
    {
        AuditLog::create([
            'user_id' => Auth::id(), // currently logged in user
            'action' => $action . ' payment',
            'auditable_type' => Payment::class,
            'auditable_id' => $payment->id,
            'old_values' => $action === 'updated' ? json_encode($payment->getOriginal()) : null,
            'new_values' => $action !== 'deleted' ? json_encode($payment->getAttributes()) : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
