<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Collector Payments Report</title>
    <style>
        @page { margin: 1cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        h3 {
            margin: 0 0 5px 0;
            font-size: 20px;
            text-transform: uppercase;
            color: #1a202c;
        }
        .meta {
            font-size: 10px;
            color: #718096;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
            table-layout: fixed;
        }
        th, td { 
            border: 1px solid #e2e8f0; 
            padding: 8px 5px; 
            text-align: left;
            word-wrap: break-word;
        }
        th { 
            background-color: #edf2f7; 
            font-weight: bold;
            text-transform: uppercase;
            color: #4a5568;
        }
        .right { text-align: right; }
        .center { text-align: center; }
        
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        /* Fixed colors to avoid dynamic logic in CSS block */
        .badge-paid { background-color: #c6f6d5; color: #22543d; }
        .badge-pending { background-color: #feebc8; color: #744210; }
        .badge-failed { background-color: #fed7d7; color: #822727; }
        .badge-default { background-color: #edf2f7; color: #2d3748; }

        .summary { 
            margin-top: 20px; 
            padding: 15px; 
            background-color: #f7fafc; 
            border: 1px solid #e2e8f0; 
        }
        .footer { 
            position: fixed; 
            bottom: 0; 
            width: 100%;
            text-align: center;
            font-size: 8px; 
            color: #a0aec0;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Collector Payments Report</h3>
        <div class="meta">
            Generated: {{ date('M d, Y | H:i') }} | 
            Records: {{ $payments->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 7%;">ID</th>
                <th style="width: 18%;">Revenue Item</th>
                <th style="width: 12%;">Amount</th>
                <th style="width: 12%;">Penalty</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 12%;">Method</th>
                <th style="width: 14%;">Reference</th>
                <th style="width: 15%;">Paid Date</th>
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
                    $penalty = $payment->penalty_amount ?? 0;
                    $totalPenalty += $penalty;

                    $status = strtolower($payment->status);
                    $badgeClass = match(true) {
                        in_array($status, ['paid','completed','success']) => 'badge-paid',
                        $status === 'pending' => 'badge-pending',
                        in_array($status, ['failed','cancelled']) => 'badge-failed',
                        default => 'badge-default'
                    };

                    // Safe Carbon parsing
                    $paidAt = $payment->paid_at ? \Illuminate\Support\Carbon::parse($payment->paid_at) : null;
                @endphp
                <tr>
                    <td class="center">#{{ $payment->id }}</td>
                    <td>{{ $payment->revenueItem->name ?? 'N/A' }}</td>
                    <td class="right">{{ number_format($payment->amount, 2) }}</td>
                    <td class="right" style="color: {{ $penalty > 0 ? '#e53e3e' : '#333' }};">
                        {{ number_format($penalty, 2) }}
                    </td>
                    <td class="center">
                        <span class="badge {{ $badgeClass }}">{{ strtoupper($payment->status) }}</span>
                    </td>
                    <td class="center">{{ strtoupper($payment->payment_method ?? 'N/A') }}</td>
                    <td>{{ $payment->reference ?? '-' }}</td>
                    <td>{{ $paidAt ? $paidAt->format('d M Y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center" style="padding: 30px;">No records found.</td>
                </tr>
            @endforelse
        </tbody>
        @if($payments->count() > 0)
        <tfoot>
            <tr style="background-color: #f7fafc; font-weight: bold;">
                <td colspan="2" class="right">Subtotals:</td>
                <td class="right">{{ number_format($totalAmount, 2) }}</td>
                <td class="right">{{ number_format($totalPenalty, 2) }}</td>
                <td colspan="4"></td>
            </tr>
            <tr style="background-color: #edf2f7; font-weight: bold;">
                <td colspan="2" class="right">GRAND TOTAL (ZMW):</td>
                <td colspan="2" class="right">{{ number_format($totalAmount + $totalPenalty, 2) }}</td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="summary">
        <div style="font-weight: bold; margin-bottom: 5px;">Summary Overview</div>
        <div>Total Collected: ZMW {{ number_format($totalAmount, 2) }}</div>
        <div>Total Penalties: ZMW {{ number_format($totalPenalty, 2) }}</div>
        <div>Final Amount: <strong>ZMW {{ number_format($totalAmount + $totalPenalty, 2) }}</strong></div>
        <div style="margin-top: 10px; font-size: 9px; color: #718096;">
            Report Period: 
            @if($payments->count() > 0)
                {{ \Illuminate\Support\Carbon::parse($payments->min('paid_at'))->format('M d, Y') }} - 
                {{ \Illuminate\Support\Carbon::parse($payments->max('paid_at'))->format('M d, Y') }}
            @else
                N/A
            @endif
        </div>
    </div>

    <div class="footer">
        Revenue System | Report generated by {{ auth()->user()->name ?? 'System' }} | © {{ date('Y') }}
    </div>
</body>
</html>