<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Revenue Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    @stack('styles')
</head>

<body x-data="{ open: false }" class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 font-sans">
    <div class="flex min-h-screen">

        <!-- Mobile overlay -->
        <div x-show="open" x-cloak class="fixed inset-0 bg-black/40 z-40 md:hidden" @click="open = false"></div>

        <!-- Mobile Sidebar -->
        <aside x-show="open" x-cloak
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl border-r border-gray-200 z-50 md:hidden">

            <div class="p-6 flex flex-col h-full">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md shadow-blue-200">
                            R
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900 leading-tight">Revenue System</div>
                            <div class="text-xs text-gray-500">Admin Panel</div>
                        </div>
                    </div>

                    <button type="button" class="p-2 rounded-lg hover:bg-gray-100" @click="open = false" aria-label="Close sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <nav class="space-y-2 flex-1">
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
                </nav>

                @auth
                    <div class="pt-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 font-semibold transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Desktop Sidebar -->
        <aside class="bg-white shadow-xl w-64 flex-shrink-0 hidden md:flex flex-col border-r border-gray-200">
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md shadow-blue-200">
                        R
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900 leading-tight">Revenue System</div>
                        <div class="text-xs text-gray-500">Admin Panel</div>
                    </div>
                </div>

                <nav class="space-y-2 flex-1">
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
                </nav>

                @auth
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex items-center gap-3 px-3 py-3 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="h-9 w-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="leading-tight min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-blue-700 font-semibold">{{ ucfirst(auth()->user()->role ?? 'User') }}</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 bg-red-50 hover:bg-red-100 font-semibold transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top bar -->
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button type="button" class="md:hidden p-2 rounded-lg hover:bg-gray-100" @click="open = true" aria-label="Open sidebar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500">
                                Logged in as:
                                <span class="font-semibold text-blue-700 uppercase">{{ optional(auth()->user())->role }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        @yield('header-actions')

                        @auth
                            <div class="hidden sm:flex items-center gap-2 px-3 py-2 bg-blue-50 rounded-xl border border-blue-100">
                                <div class="h-8 w-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="leading-tight">
                                    <p class="text-sm font-semibold text-gray-900 truncate max-w-[180px]">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-xs text-blue-700 font-semibold">{{ ucfirst(auth()->user()->role ?? 'User') }}</p>
                                </div>
                            </div>

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                        class="text-sm font-semibold text-red-600 border border-red-200 px-3 py-2 rounded-lg hover:bg-red-50 transition">
                                    Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
<footer class="bg-gray-900 text-gray-400 border-t border-gray-800 mt-auto">
  <div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-col items-center justify-center text-center gap-4">

      <div class="text-sm">
        &copy; {{ date('Y') }} <span class="font-semibold text-white">Revenue System</span>
        <span class="block text-gray-500">
          Developed by <span class="text-blue-400 font-medium">Kundananji Simukonda</span>
        </span>
      </div>

      <div class="flex flex-wrap items-center justify-center gap-3 text-xs font-medium">
        <a href="mailto:kundananjisimukonda@gmail.com"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg hover:text-blue-400 hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-blue-400/40 transition">
          <span>Email</span>
        </a>

        <a href="tel:+260971863462"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg hover:text-blue-400 hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-blue-400/40 transition">
          <span>Call</span>
        </a>

        <a href="https://www.linkedin.com/in/kundananji-simukonda" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg hover:text-blue-400 hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-blue-400/40 transition">
          <span>LinkedIn</span>
        </a>

        <a href="https://github.com/Kundananjik" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg hover:text-blue-400 hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-blue-400/40 transition">
          <span>GitHub</span>
        </a>
      </div>

    </div>
  </div>
</footer>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
