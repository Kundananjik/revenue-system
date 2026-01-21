<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') | Revenue Portal</title>

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

        @include('layouts.user.sidebar')

        <!-- Main -->
        <div class="flex-1 flex flex-col min-w-0">

            @include('layouts.user.header')

            <!-- Content -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    @yield('content')
                </div>
            </main>

            @include('layouts.user.footer')

        </div>
    </div>

    @stack('scripts')
</body>
</html>
