<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    protected ?int $userId;
    protected ?int $collectorId;

    public function __construct(?int $userId = null, ?int $collectorId = null)
    {
        $this->userId = $userId;
        $this->collectorId = $collectorId;
    }

    public function collection(): Collection
    {
        $q = Payment::with(['payer', 'revenueItem', 'collector'])->latest();

        // Filter by payer (user)
        if ($this->userId !== null) {
            $q->where('user_id', $this->userId);
        }

        // Filter by collector
        if ($this->collectorId !== null) {
            $q->where('collected_by', $this->collectorId);
        }

        return $q->get()->map(function ($payment) {
            return [
                $payment->id,
                $payment->payer->name ?? '-',
                $payment->revenueItem->name ?? '-',
                (string) $payment->amount,
                (string) $payment->penalty_amount,
                ucfirst((string) $payment->status),
                $payment->payment_method ?? '-',
                $payment->reference ?? '-',
                $payment->collector->name ?? '-',
                $payment->paid_at?->format('Y-m-d H:i') ?? '-',
                $payment->created_at?->format('Y-m-d H:i') ?? '-',
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
