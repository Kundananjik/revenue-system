<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return Payment::with(['payer', 'revenueItem', 'collector'])
            ->where('user_id', $this->userId)
            ->get()
            ->map(function($payment) {
                return [
                    'ID' => $payment->id,
                    'Payer' => $payment->payer->name ?? '-',
                    'Revenue Item' => $payment->revenueItem->name ?? '-',
                    'Amount' => $payment->amount,
                    'Penalty' => $payment->penalty_amount,
                    'Status' => ucfirst($payment->status),
                    'Method' => $payment->payment_method ?? '-',
                    'Reference' => $payment->reference ?? '-',
                    'Collector' => $payment->collector->name ?? '-',
                    'Paid At' => $payment->paid_at?->format('Y-m-d H:i') ?? '-',
                    'Created At' => $payment->created_at?->format('Y-m-d H:i') ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID', 'Payer', 'Revenue Item', 'Amount', 'Penalty', 'Status', 
            'Method', 'Reference', 'Collector', 'Paid At', 'Created At'
        ];
    }
}
