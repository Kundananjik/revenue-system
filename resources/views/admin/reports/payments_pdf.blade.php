<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payments Report</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10px; 
            color: #333;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        th, td { 
            border: 0.5px solid #ccc; 
            padding: 6px 4px; 
            text-align: left;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .right { 
            text-align: right; 
        }
        .center {
            text-align: center;
        }
        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h3>Payments Report</h3>
<p style="margin-bottom: 10px;">Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Payer Name</th>
            <th>Revenue Item</th>
            <th>Amount (ZMW)</th>
            <th>Penalty (ZMW)</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Reference</th>
            <th>Paid At</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $totalAmount = 0; 
            $totalPenalty = 0;
        @endphp
        @forelse($payments as $payment)
            @php 
                $totalAmount += $payment->amount;
                $totalPenalty += $payment->penalty_amount;
            @endphp
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->payer->name ?? 'N/A' }}</td>
                <td>{{ $payment->revenueItem->name ?? 'N/A' }}</td>
                <td class="right">{{ number_format($payment->amount, 2) }}</td>
                <td class="right">{{ number_format($payment->penalty_amount ?? 0, 2) }}</td>
                <td class="center">{{ ucfirst($payment->status) }}</td>
                <td class="center">{{ strtoupper($payment->payment_method ?? 'N/A') }}</td>
                
                <td>{{ $payment->reference ?? '-' }}</td>
                <td>{{ $payment->paid_at?->format('Y-m-d H:i') ?? '-' }}</td>
                <td>{{ $payment->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="10" style="text-align:center;">No payments found.</td>
            </tr>
        @endforelse
    </tbody>
    @if($payments->count() > 0)
    <tfoot>
        <tr class="total-row">
            <td colspan="3" class="right">TOTALS:</td>
            <td class="right">{{ number_format($totalAmount, 2) }}</td>
            <td class="right">{{ number_format($totalPenalty, 2) }}</td>
            <td colspan="5" style="background-color: white; border: none;"></td>
        </tr>
    </tfoot>
    @endif
</table>

</body>
</html>