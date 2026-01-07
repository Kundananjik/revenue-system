@extends('admin.layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Audit Logs</h1>
            <p class="text-sm text-gray-600 mt-1">Track all system activities and changes</p>
        </div>
        
        {{-- Export Buttons Section --}}
        @if(auth()->user()->role === 'super-admin')
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.reports.audit-logs.pdf') }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.reports.audit-logs.excel') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        @endif
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
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Timestamp</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $log->id }}</td>
                        
                        {{-- User with Avatar --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if($log->user)
                                    <div class="h-8 w-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                        {{ strtoupper(substr($log->user->name, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $log->user->name }}</span>
                                @else
                                    <div class="h-8 w-8 bg-gradient-to-br from-gray-500 to-gray-600 rounded-full flex items-center justify-center text-white">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-500 italic">System</span>
                                @endif
                            </div>
                        </td>
                        
                        {{-- Action Badge with Icon --}}
                        <td class="px-4 py-3">
                            @php
                                $actionConfig = match(strtolower($log->action)) {
                                    'created', 'create' => ['class' => 'bg-green-100 text-green-800 border-green-200', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                                    'updated', 'update' => ['class' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                                    'deleted', 'delete' => ['class' => 'bg-red-100 text-red-800 border-red-200', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
                                    'viewed', 'view' => ['class' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                                    'login', 'logged in' => ['class' => 'bg-indigo-100 text-indigo-800 border-indigo-200', 'icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1'],
                                    'logout', 'logged out' => ['class' => 'bg-gray-100 text-gray-800 border-gray-200', 'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1'],
                                    default => ['class' => 'bg-gray-100 text-gray-800 border-gray-200', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full border {{ $actionConfig['class'] }} uppercase">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $actionConfig['icon'] }}"/>
                                </svg>
                                {{ $log->action }}
                            </span>
                        </td>
                        
                        {{-- Model --}}
                        <td class="px-4 py-3 text-sm">
                            <span class="inline-flex items-center gap-1 bg-gray-100 px-2.5 py-1 rounded-md text-xs font-medium text-gray-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                                {{ class_basename($log->auditable_type) }}
                            </span>
                        </td>
                        
{{-- Changes --}}
<td class="px-4 py-3">
    @php
        // Ensure $newValues is always an array
        $newValues = is_array($log->new_values) 
            ? $log->new_values 
            : json_decode($log->new_values, true);
    @endphp

    @if(!empty($newValues))
        <div class="max-w-xs">
            <details class="cursor-pointer">
                <summary class="text-xs font-medium text-blue-600 hover:text-blue-800">
                    View {{ count($newValues) }} change{{ count($newValues) > 1 ? 's' : '' }}
                </summary>
                <div class="mt-2 p-2 bg-gray-50 rounded text-xs text-gray-700 max-h-32 overflow-auto">
                    @foreach($newValues as $key => $value)
                        <div class="mb-1">
                            <span class="font-semibold text-gray-900">{{ $key }}:</span>
                            <span class="text-gray-600">
                                {{ is_array($value) ? json_encode($value) : $value }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </details>
        </div>
    @else
        <span class="text-xs text-gray-400 italic">No changes</span>
    @endif
</td>                        
                        {{-- IP Address --}}
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center gap-1 text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <span class="font-mono text-xs">{{ $log->ip_address }}</span>
                            </div>
                        </td>
                        
                        {{-- Date --}}
                        <td class="px-4 py-3 text-sm whitespace-nowrap">
                            <div class="flex flex-col text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs font-medium">{{ $log->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-1 ml-4">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-16 h-16 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg font-medium mb-1">No audit logs found</p>
                                <p class="text-sm text-gray-400">System activities will be recorded here</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($logs->hasPages())
        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    @endif

    {{-- Summary Footer --}}
    @if($logs->isNotEmpty())
        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
            <div class="flex flex-wrap items-center justify-between gap-4 text-sm">
                <div class="text-gray-600">
                    Showing <span class="font-semibold text-gray-900">{{ $logs->count() }}</span> of 
                    <span class="font-semibold text-gray-900">{{ $logs->total() }}</span> total logs
                </div>
                <div class="flex flex-wrap gap-4">
                    @php
                        $actionCounts = $logs->groupBy('action')->map->count();
                    @endphp
                    @foreach($actionCounts as $action => $count)
                        <span class="text-gray-600">
                            <span class="font-semibold text-gray-900">{{ $count }}</span> {{ ucfirst($action) }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</div>
@endsection