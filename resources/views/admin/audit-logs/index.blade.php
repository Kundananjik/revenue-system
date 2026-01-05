@extends('admin.layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Audit Logs</h1>
        </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Model</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Changes</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Address</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $log->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $log->user->name ?? 'System' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-700 uppercase">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            {{ class_basename($log->auditable_type) }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            <div class="max-w-xs truncate">
                                <strong>New:</strong> {{ json_encode($log->new_values) }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $log->ip_address }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $log->created_at->format('M d, Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500 font-medium">
                            No audit logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
@endsection