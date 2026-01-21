<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Collector Payments Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin: 0 0 10px 0; }
        .meta { margin-bottom: 12px; font-size: 11px; color: #444; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
        .badge { padding: 2px 6px; border-radius: 10px; font-size: 10px; }
    </style>
</head>
<body>
    <h2>Collector Payments Report</h2>
    <div class="meta">
        Generated: {{ now()->format('Y-m-d H:i') }}<br>
        Total Records: {{ $payments->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Payer</th>
                <th>Item</th>
                <th class="right">Amount</th>
                <th class="right">Penalty</th>
                <th>Method</th>
                <th>Status</th>
                <th>Reference</th>
                <th>Paid At</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->payer->name ?? '-' }}</td>
                    <td>{{ $p->revenueItem->name ?? '-' }}</td>
                    <td class="right">ZMW {{ number_format((float)$p->amount, 2) }}</td>
                    <td class="right">ZMW {{ number_format((float)$p->penalty_amount, 2) }}</td>
                    <td>{{ $p->payment_method ?? '-' }}</td>
                    <td>{{ ucfirst((string)$p->status) }}</td>
                    <td>{{ $p->reference ?? '-' }}</td>
                    <td>{{ $p->paid_at ? $p->paid_at->format('Y-m-d H:i') : '-' }}</td>
                    <td>{{ $p->created_at ? $p->created_at->format('Y-m-d H:i') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
