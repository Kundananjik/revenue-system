<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>My Payments Report</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 10px; 
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        h3 {
            margin: 0 0 5px 0;
            font-size: 18px;
            text-transform: uppercase;
            color: #000;
        }
        .meta {
            font-size: 9px;
            color: #666;
            margin-top: 5px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 6px 4px; 
            text-align: left;
            vertical-align: top;
        }
        th { 
            background-color: #f5f5f5; 
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            color: #555;
        }
        td {
            font-size: 9px;
        }
        .right { 
            text-align: right; 
        }
        .center {
            text-align: center;
        }
        .total-row {
            background-color: #e8f4f8;
            font-weight: bold;
            font-size: 10px;
        }
        .amount {
            font-weight: bold;
            color: #000;
        }
        .penalty {
            color: #c00;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-paid {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-failed {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-default {
            background-color: #e2e3e5;
            color: #383d41;
        }
        .summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .summary-title {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 5px;
        }
        .summary-item {
            font-size: 9px;
            margin: 3px 0;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 8px;
            color: #666;
            text-align: center;
        }
        .small {
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>My Payments Report</h3>
        <div class="meta">
            Generated on: {{ now()->format('F d, Y \a\t H:i:s') }} | 
            Total Records: {{ $payments->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 15%;">Revenue Item</th>
                <th style="width: 12%;">Amount (ZMW)</th>
                <th style="width: 10%;">Penalty (ZMW)</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Payment Method</th>
                <th style="width: 12%;">Reference</th>
                <th style="width: 12%;">Paid Date</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalAmount = 0; 
                $totalPenalty = 0;
                $statusCounts = ['paid'=>0,'pending'=>0,'failed'=>0];
            @endphp
            @forelse($payments as $payment)
                @php 
                    $totalAmount += $payment->amount;
                    $totalPenalty += $payment->penalty_amount ?? 0;
                    
                    $status = strtolower($payment->status);
                    if(in_array($status, ['paid','completed','success'])) {
                        $statusCounts['paid']++;
                        $badgeClass = 'badge-paid';
                    } elseif($status === 'pending') {
                        $statusCounts['pending']++;
                        $badgeClass = 'badge-pending';
                    } elseif(in_array($status, ['failed','cancelled'])) {
                        $statusCounts['failed']++;
                        $badgeClass = 'badge-failed';
                    } else {
                        $badgeClass = 'badge-default';
                    }
                @endphp
                <tr>
                    <td class="center">{{ $payment->id }}</td>
                    <td class="small">{{ $payment->revenueItem->name ?? 'N/A' }}</td>
                    <td class="right amount">{{ number_format($payment->amount, 2) }}</td>
                    <td class="right {{ $payment->penalty_amount > 0 ? 'penalty' : '' }}">
                        {{ number_format($payment->penalty_amount ?? 0, 2) }}
                    </td>
                    <td class="center">
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($payment->status) }}</span>
                    </td>
                    <td class="center small">{{ strtoupper($payment->payment_method ?? 'N/A') }}</td>
                    <td class="small">{{ $payment->reference ?? '-' }}</td>
                    <td class="small">{{ $payment->paid_at?->format('M d, Y H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding: 20px; color: #999;">
                        No payments found.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($payments->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="right">TOTALS:</td>
                <td class="right amount">ZMW {{ number_format($totalAmount, 2) }}</td>
                <td class="right {{ $totalPenalty > 0 ? 'penalty' : '' }}">ZMW {{ number_format($totalPenalty, 2) }}</td>
                <td colspan="4"></td>
            </tr>
            <tr class="total-row">
                <td colspan="2" class="right">GRAND TOTAL:</td>
                <td colspan="2" class="right amount" style="font-size: 11px;">ZMW {{ number_format($totalAmount + $totalPenalty, 2) }}</td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    @if($payments->isNotEmpty())
        <div class="summary">
            <div class="summary-title">Payment Summary</div>
            <div class="summary-item">
                <strong>Total Payments:</strong> {{ $payments->count() }}
            </div>
            <div class="summary-item">
                <strong>Status Breakdown:</strong>
                Paid ({{ $statusCounts['paid'] }}), 
                Pending ({{ $statusCounts['pending'] }}), 
                Failed ({{ $statusCounts['failed'] }})
            </div>
            <div class="summary-item">
                <strong>Total Amount Collected:</strong> ZMW {{ number_format($totalAmount, 2) }}
            </div>
            <div class="summary-item">
                <strong>Total Penalties:</strong> ZMW {{ number_format($totalPenalty, 2) }}
            </div>
            <div class="summary-item">
                <strong>Grand Total:</strong> ZMW {{ number_format($totalAmount + $totalPenalty, 2) }}
            </div>
        </div>
    @endif

    <div class="footer">
        My Payments Report | © {{ date('Y') }} | Page generated at {{ now()->format('H:i:s') }}
    </div>
</body>
</html>
