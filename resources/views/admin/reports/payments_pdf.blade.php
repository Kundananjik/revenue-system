<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #eee; }
    </style>
</head>
<body>
<h3>Payments Report</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Payer</th>
            <th>Item</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->payer->name ?? '-' }}</td>
                <td>{{ $payment->revenueItem->name ?? '-' }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->status }}</td>
                <td>{{ $payment->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
