<header class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200/60 sticky top-0 z-30">

    <!-- MOBILE HEADER -->
    <div class="md:hidden flex justify-between items-center p-4">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">
                R
            </div>
            <span class="font-bold text-gray-800">Revenue System</span>
        </div>

        <!-- Menu Button -->
        <button id="menuBtn" class="bg-blue-600 text-white p-2 rounded-lg shadow">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

    </div>

    <!-- DESKTOP HEADER -->
    <div class="hidden md:flex justify-between items-center p-4">

        <!-- Page Title -->
        <div>
            <h2 class="text-lg font-semibold text-gray-800">
                @yield('page-title', 'Dashboard')
            </h2>
            <p class="text-sm text-gray-500">
                Welcome back, {{ auth()->user()->name }}
            </p>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">

            <!-- Status -->
            <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 rounded-lg border border-blue-100">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-xs font-medium text-blue-700">Active</span>
            </div>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-2 text-sm font-semibold text-red-600
                    border border-red-200 px-4 py-2 rounded-lg
                    hover:bg-red-50 transition">

                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1
                              a3 3 0 01-3 3H6a3 3 0 01-3-3V7
                              a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>

                    Logout
                </button>
            </form>

        </div>

    </div>

</header>

{{-- Mobile sidebar script --}}
<script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const closeBtn = document.getElementById('closeBtn');

    menuBtn?.addEventListener('click', () => {
        mobileSidebar.classList.remove('hidden');
    });

    closeBtn?.addEventListener('click', () => {
        mobileSidebar.classList.add('hidden');
    });
</script>
