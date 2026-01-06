<?php
namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping; // Add this

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Eager load relationships to prevent N+1 performance issues
        return Payment::with(['payer', 'revenueItem'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Payer Name',
            'Revenue Item',
            'Amount',
            'Penalty',
            'Status',
            'Method',
            'Reference',
            'Paid At',
            'Created At'
        ];
    }

    /**
    * @var Payment $payment
    */
    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->payer->name ?? 'N/A',            // Show Name instead of ID
            $payment->revenueItem->name ?? 'N/A',      // Show Item Name instead of ID
            number_format($payment->amount, 2),        // Format currency
            number_format($payment->penalty_amount, 2),
            strtoupper($payment->status),
            $payment->payment_method,
            $payment->reference,
            $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : 'Unpaid',
            $payment->created_at->format('Y-m-d H:i'),
        ];
    }
}