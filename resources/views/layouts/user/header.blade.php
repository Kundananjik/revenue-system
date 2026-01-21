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
