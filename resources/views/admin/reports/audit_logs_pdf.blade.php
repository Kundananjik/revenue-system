<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Audit Logs Report</title>
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
            margin-top: 10px;
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
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .small {
            font-size: 8px;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-create {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-update {
            background-color: #cce5ff;
            color: #004085;
        }
        .badge-delete {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-default {
            background-color: #e2e3e5;
            color: #383d41;
        }
        .amount {
            font-weight: bold;
            color: #000;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 8px;
            color: #666;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="header">
        <h3>Audit Logs Report</h3>
        <div class="meta">
            Generated on: {{ now()->format('F d, Y \a\t H:i:s') }} | 
            Total Records: {{ $logs->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 12%;">User</th>
                <th style="width: 10%;">Action</th>
                <th style="width: 12%;">Model</th>
                <th style="width: 8%;">Record ID</th>
                <th style="width: 18%;">Changes</th>
                <th style="width: 12%;">IP Address</th>
                <th style="width: 15%;">Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td class="text-center">{{ $log->id }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>
                        @php
                            $actionClass = match(strtolower($log->action)) {
                                'created', 'create' => 'badge-create',
                                'updated', 'update' => 'badge-update',
                                'deleted', 'delete' => 'badge-delete',
                                default => 'badge-default',
                            };
                        @endphp
                        <span class="badge {{ $actionClass }}">{{ $log->action }}</span>
                    </td>
                    <td class="small">{{ class_basename($log->auditable_type) }}</td>
                    <td class="text-center">{{ $log->auditable_id }}</td>
                    <td class="small">
                        @if($log->new_values && is_array($log->new_values) && count($log->new_values) > 0)
                            @foreach($log->new_values as $key => $value)
                                @if($loop->index < 3)
                                    <strong>{{ $key }}:</strong> 
                                    @if(in_array($key, ['amount', 'penalty_amount']))
                                        <span class="amount">ZMW {{ number_format((float)$value, 2) }}</span>
                                    @else
                                        {{ is_array($value) ? json_encode($value) : (strlen((string)$value) > 30 ? substr((string)$value, 0, 30) . '...' : $value) }}
                                    @endif
                                    <br/>
                                @endif
                            @endforeach
                            @if(count($log->new_values) > 3)
                                <em>+{{ count($log->new_values) - 3 }} more</em>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center small">{{ $log->ip_address ?? '-' }}</td>
                    <td class="small">{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #999;">
                        No audit logs found for the selected period.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($logs->isNotEmpty())
        <div class="summary">
            <div class="summary-title">Summary</div>
            @php
                $actionCounts = $logs->groupBy('action')->map->count();
                $userCounts = $logs->groupBy('user_id')->count();
            @endphp
            <div class="summary-item">
                <strong>Total Logs:</strong> {{ $logs->count() }}
            </div>
            <div class="summary-item">
                <strong>Unique Users:</strong> {{ $userCounts }}
            </div>
            <div class="summary-item">
                <strong>Actions:</strong>
                @foreach($actionCounts as $action => $count)
                    {{ ucfirst($action) }} ({{ $count }}){{ !$loop->last ? ', ' : '' }}
                @endforeach
            </div>
            <div class="summary-item">
                <strong>Date Range:</strong> 
                {{ $logs->min('created_at')->format('M d, Y') }} - {{ $logs->max('created_at')->format('M d, Y') }}
            </div>
        </div>
    @endif

    <div class="footer">
        Revenue System | Audit Logs Report | 
        © {{ date('Y') }} Developed by Kundananji Simukonda | 
        Page generated at {{ now()->format('H:i:s') }}
    </div>
</body>
</html>