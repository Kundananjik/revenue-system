<a href="{{ route('admin.dashboard') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1"/>
    </svg>
    Dashboard
</a>

<a href="{{ route('admin.categories.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
   {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    Categories
</a>

<a href="{{ route('admin.items.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
   {{ request()->routeIs('admin.items.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Revenue Items
</a>

<a href="{{ route('admin.payments.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
   {{ request()->routeIs('admin.payments.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    Payments
</a>

<a href="{{ route('admin.imports.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
   {{ request()->routeIs('admin.imports.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 10v6m0-6l-2 2m2-2l2 2M4 15v4a2 2 0 002 2h12a2 2 0 002-2v-4M4 7a2 2 0 012-2h12a2 2 0 012 2v4H4V7z"/>
    </svg>
    Imports
</a>

<a href="{{ route('admin.penalties.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
   {{ request()->routeIs('admin.penalties.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    Penalties
</a>

<a href="{{ route('admin.users.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-xl transition
   {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>
    Users
</a>

@if(auth()->check() && auth()->user()->role === 'super-admin')
    <div class="pt-4 mt-4 border-t border-gray-100">
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">System</p>
        <a href="{{ route('admin.reports.audit-logs.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
           {{ request()->routeIs('admin.reports.audit-logs.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Audit Logs</span>
        </a>
    </div>
@endif

@auth
    <div class="pt-4 mt-4 border-t border-gray-200">
        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Account Settings</p>
        <a href="{{ route('user.profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition
           {{ request()->routeIs('user.profile.*') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>My Profile</span>
        </a>
    </div>
@endauth
