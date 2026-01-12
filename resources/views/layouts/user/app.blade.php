<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Revenue Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>
<body x-data="{ sidebarOpen: false }" class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 font-sans">

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.user.sidebar', ['sidebarOpen' => 'sidebarOpen'])

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">
            <!-- Header -->
            @include('layouts.user.header', ['sidebarOpen' => 'sidebarOpen'])

            <!-- Main Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.user.footer')
        </div>
    </div>

</body>
</html>
