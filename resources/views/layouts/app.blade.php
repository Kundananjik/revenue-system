<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard') | Revenue System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    @stack('styles')
</head>

<body x-data="{ open: false }" x-on:keydown.escape.window="open = false" class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 font-sans">
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
               class="fixed inset-y-0 left-0 w-[86vw] max-w-72 bg-white shadow-2xl border-r border-gray-200 z-50 md:hidden">

            <div class="p-6 flex flex-col h-full">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md shadow-blue-200">
                            R
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900 leading-tight">Revenue System</div>
                        </div>
                    </div>

                    <button type="button" class="p-2 rounded-lg hover:bg-gray-100" @click="open = false" aria-label="Close sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <nav class="space-y-2 flex-1 overflow-y-auto pr-1" @click="if ($event.target.closest('a')) open = false">
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super-admin')
                            @include('layouts.partials.sidebar-admin')
                        @elseif(auth()->user()->role === 'collector')
                            @include('layouts.partials.sidebar-collector')
                        @else
                            @include('layouts.partials.sidebar-user')
                        @endif
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

        <!-- Desktop Sidebar -->
        <aside class="bg-white shadow-xl w-64 flex-shrink-0 hidden md:flex flex-col border-r border-gray-200">
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-md shadow-blue-200">
                        R
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900 leading-tight">Revenue System</div>
                    </div>
                </div>

                <nav class="space-y-2 flex-1">
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super-admin')
                            @include('layouts.partials.sidebar-admin')
                        @elseif(auth()->user()->role === 'collector')
                            @include('layouts.partials.sidebar-collector')
                        @else
                            @include('layouts.partials.sidebar-user')
                        @endif
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
            @include('layouts.partials.header')

            <main class="px-3 py-4 sm:px-6 sm:py-6">
                {{ $slot ?? $content ?? '' }}
                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
