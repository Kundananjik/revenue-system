<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Audit Logs Report</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 10px;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .small {
            font-size: 9px;
        }
    </style>
</head>
<body>

<h3>Audit Logs Report</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Action</th>
            <th>Model</th>
            <th>Model ID</th>
            <th>Old Amount</th>
            <th>New Amount</th>
            <th>IP Address</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->user->name ?? 'System' }}</td>
                <td class="small">{{ $log->action }}</td>
                <td>{{ class_basename($log->auditable_type) }}</td>
                <td>{{ $log->auditable_id }}</td>
                <td>
                    @if($log->auditable_type === \App\Models\Payment::class)
                        {{ $log->old_values['amount'] ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($log->auditable_type === \App\Models\Payment::class)
                        {{ $log->new_values['amount'] ?? '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $log->ip_address ?? '-' }}</td>
                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align:center;">
                    No audit logs found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
