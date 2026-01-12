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
</head>
<body x-data="{ open: false }" class="flex flex-col min-h-screen bg-gray-100 font-sans">

    <div class="flex flex-1 overflow-hidden">
        <!-- Desktop Sidebar -->
        <aside class="bg-white shadow-xl w-64 flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6 flex-1">
                <h1 class="text-2xl font-bold text-blue-600 mb-8">Revenue Admin</h1>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded transition hover:bg-blue-50 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded transition hover:bg-blue-50 {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Categories
                    </a>

                    <a href="{{ route('admin.items.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded transition hover:bg-blue-50 {{ request()->routeIs('admin.items.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Revenue Items
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded transition hover:bg-blue-50 {{ request()->routeIs('admin.payments.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Payments
                    </a>

                    <a href="{{ route('admin.penalties.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded transition hover:bg-blue-50 {{ request()->routeIs('admin.penalties.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Penalties
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded transition hover:bg-blue-50 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Users
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'super-admin')
                        <div class="pt-4 mt-4 border-t border-gray-100">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">System</p>
                            <a href="{{ route('admin.audit-logs.index') }}"
                               class="flex items-center gap-3 px-4 py-2 rounded transition hover:bg-blue-50 {{ request()->routeIs('admin.audit-logs.*') ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Audit Logs
                            </a>
                        </div>
                    @endif

                    <!-- Account Settings (visible to all authenticated admins) -->
                    @auth
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Account Settings</p>
                            <a href="{{ route('profile.edit') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>My Profile</span>
                            </a>
                        </div>
                    @endauth
                </nav>
            </div>
        </aside>

        <!-- Mobile Sidebar (slide-in) -->
        <aside x-show="open"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-300"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 bg-white w-64 z-50 shadow-2xl md:hidden"
               @click.away="open = false"
               style="display: none;">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-blue-600">Revenue Admin</h1>
                    <button @click="open = false" class="text-gray-500 text-2xl">&times;</button>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Categories
                    </a>
                    <a href="{{ route('admin.items.index') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('admin.items.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Revenue Items
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('admin.payments.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Payments
                    </a>
                    <a href="{{ route('admin.penalties.index') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('admin.penalties.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Penalties
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Users
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'super-admin')
                        <a href="{{ route('admin.audit-logs.index') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('admin.audit-logs.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Audit Logs
                        </a>
                    @endif

                    @auth
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Account</p>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 rounded {{ request()->routeIs('profile.edit') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                My Profile
                            </a>
                        </div>
                    @endauth
                </nav>
            </div>
        </aside>

        <!-- Main content area -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            <header class="bg-white shadow-sm border-b p-4 flex justify-between items-center sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="open = true" class="md:hidden bg-blue-600 text-white p-2 rounded-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                    <div class="hidden md:block text-gray-500 italic text-sm">
                        Logged in as: <span class="font-bold text-blue-600 uppercase">{{ optional(auth()->user())->role }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <span class="text-gray-700 font-medium">{{ optional(auth()->user())->name }}</span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-sm font-semibold text-red-500 hover:text-red-700 border border-red-200 px-3 py-1 rounded-md hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <footer class="bg-gray-900 text-gray-400 py-6 px-4 border-t border-gray-800 mt-auto">
                <div class="max-w-7xl mx-auto flex flex-col items-center justify-center space-y-4">
                    <div class="text-center text-sm">
                        &copy; {{ date('Y') }} <span class="font-bold text-white">Revenue System</span> Developed by
                        <span class="text-blue-400 font-medium">Kundananji Simukonda</span>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4 md:gap-6 text-xs font-medium items-center">
                        <a href="mailto:kundananjisimukonda@gmail.com" class="flex items-center hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email
                        </a>

                        <a href="tel:+260971863462" class="flex items-center hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Call
                        </a>

                        <a href="https://www.linkedin.com/in/kundananji-simukonda" target="_blank" class="flex items-center hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.25c-.97 0-1.75-.78-1.75-1.75s.78-1.75 1.75-1.75 1.75.78 1.75 1.75-.78 1.75-1.75 1.75zm13.5 11.25h-3v-5.5c0-1.38-1.12-2.5-2.5-2.5s-2.5 1.12-2.5 2.5v5.5h-3v-10h3v1.4c.8-1.2 2.5-1.4 3.5-.2 1 1.2 1 3 1 3v5.8z"/>
                            </svg>
                            LinkedIn
                        </a>

                        <a href="https://github.com/Kundananjik" target="_blank" class="flex items-center hover:text-blue-400 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.418-1.305.762-1.604-2.665-.3-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.301 1.23a11.52 11.52 0 013.003-.404c1.018.005 2.042.138 3.003.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.235 1.912 1.235 3.222 0 4.61-2.804 5.625-5.476 5.922.43.372.815 1.102.815 2.222 0 1.606-.015 2.896-.015 3.286 0 .32.218.694.825.576 4.765-1.588 8.199-6.084 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            GitHub
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

</body>
</html>