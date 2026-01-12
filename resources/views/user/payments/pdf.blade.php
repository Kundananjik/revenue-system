<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Payments PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px; font-size: 9px; }
        th { background: #f0f0f0; text-transform: uppercase; }
        .right { text-align: right; }
        .center { text-align: center; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">My Payments Report</h3>
    <p>Generated on: {{ now()->format('F d, Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Payer</th>
                <th>Revenue Item</th>
                <th>Amount</th>
                <th>Penalty</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Collector</th>
                <th>Paid At</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAmount = 0; @endphp
            @foreach($payments as $payment)
                @php $totalAmount += $payment->amount; @endphp
                <tr>
                    <td class="center">{{ $payment->id }}</td>
                    <td>{{ $payment->payer->name ?? '-' }}</td>
                    <td>{{ $payment->revenueItem->name ?? '-' }}</td>
                    <td class="right">{{ number_format($payment->amount, 2) }}</td>
                    <td class="right">{{ number_format($payment->penalty_amount ?? 0, 2) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                    <td>{{ strtoupper($payment->payment_method ?? '-') }}</td>
                    <td>{{ $payment->collector->name ?? '-' }}</td>
                    <td>{{ $payment->paid_at?->format('d M Y H:i') ?? '-' }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3" class="right">TOTAL AMOUNT:</td>
                <td class="right">{{ number_format($totalAmount, 2) }}</td>
                <td colspan="5"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
