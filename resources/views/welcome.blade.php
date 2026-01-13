<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Revenue System - Comprehensive solution for tracking financial growth, managing user roles, and generating detailed reports in Zambia">
    <meta name="keywords" content="revenue management, financial tracking, payment system, Zambia, ZMW currency, revenue analytics">
    <meta name="author" content="Kundananji Simukonda">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Revenue System - Manage Your Revenue with Precision">
    <meta property="og:description" content="A comprehensive solution for tracking financial growth and managing revenue with ease">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Revenue System - Manage Your Revenue with Precision">
    <meta name="twitter:description" content="A comprehensive solution for tracking financial growth and managing revenue with ease">
    
    <title>Welcome | Revenue System</title>
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 flex flex-col antialiased">

<!-- Navigation -->
<nav class="bg-white/80 backdrop-blur-sm border-b border-gray-200/60 py-4 px-6 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center gap-2 sm:gap-3">
            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm sm:text-base">
                R
            </div>
            <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                Revenue System
            </span>
        </div>
        
        <!-- Auth Links -->
        <div class="flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="text-gray-700 hover:text-blue-600 font-semibold transition-colors duration-200">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-700 hover:text-blue-600 font-semibold px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-50">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold hover:shadow-lg hover:shadow-blue-200 transition-all duration-200 transform hover:-translate-y-0.5">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

    <!-- Main Content -->
    <main class="flex-grow flex items-center py-12">
        <div class="max-w-7xl mx-auto px-6 py-16 grid lg:grid-cols-2 gap-16 items-center w-full">
            
            <!-- Left Column: Hero Content -->
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-100 rounded-full text-sm font-semibold text-blue-700">
                    <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                    Financial Management Platform
                </div>
                
                <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-[1.1] tracking-tight">
                    Manage your<br/>
                    <span class="bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">Revenue</span> with<br/>
                    precision and ease
                </h1>
                
                <p class="text-xl text-gray-600 leading-relaxed max-w-xl">
                    A comprehensive solution for tracking financial growth, managing user roles, and generating detailed reports. Streamline your workflow with our secure and intuitive platform.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('register') }}" class="group flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-blue-200/50 transition-all duration-300 transform hover:-translate-y-1">
                        Get Started Free
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="flex items-center justify-center px-8 py-4 bg-white border-2 border-gray-200 text-gray-800 rounded-xl font-bold text-lg hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                        Sign In
                    </a>
                </div>

                <div class="flex items-center gap-8 pt-4 text-sm">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <span class="font-medium">Secure & Encrypted</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <span class="font-medium">Real-time Analytics</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Feature Showcase -->
            <div class="hidden lg:block relative">
                <div class="bg-white p-8 rounded-2xl shadow-2xl border border-gray-100/50 backdrop-blur-sm">
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h5m0 0v5m0-5l-5 5m-5-5h5m0 0v5"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Dashboard Overview</p>
                                <p class="text-xl font-bold text-gray-900">Revenue Analytics</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="space-y-3">
                            <!-- Feature 1: Revenue Tracking -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Revenue Tracking</p>
                                        <p class="text-sm font-semibold text-gray-900">Real-time Updates</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                            </div>

                            <!-- Feature 2: Detailed Reports -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Detailed Reports</p>
                                        <p class="text-sm font-semibold text-gray-900">Export & Analyze</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                            </div>

                            <!-- Feature 3: Role Management -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Role Management</p>
                                        <p class="text-sm font-semibold text-gray-900">Secure Access</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl border border-blue-200/50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-600 font-medium mb-1">System Status</p>
                                    <p class="text-lg font-bold text-gray-900">All Systems Operational</p>
                                </div>
                                <div class="h-3 w-3 bg-green-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating Card -->
                <div class="absolute -bottom-8 -left-8 bg-gradient-to-br from-blue-600 to-blue-700 text-white p-6 rounded-2xl shadow-2xl shadow-blue-900/20 border border-blue-500/20">
                    <p class="text-xs opacity-90 uppercase tracking-wider font-bold mb-1">Platform Access</p>
                    <p class="text-2xl font-extrabold">Comprehensive Control</p>
                    <p class="text-xs opacity-80 mt-2">Manage your revenue with ease</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-b from-gray-900 to-gray-950 text-gray-400 py-8 px-4 border-t border-gray-800 w-full">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col items-center justify-center space-y-6">
                <div class="text-center">
                    <p class="text-sm mb-2">
                        &copy; {{ date('Y') }} <span class="font-bold text-white">Revenue System</span>
                    </p>
                    <p class="text-xs text-gray-500">
                        Developed by <span class="text-blue-400 font-semibold">Kundananji Simukonda</span>
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-6 items-center">
                    <a href="mailto:kundananjisimukonda@gmail.com" class="group flex items-center gap-2 hover:text-blue-400 transition-all duration-200 text-sm font-medium" aria-label="Email">
                        <div class="p-2 bg-gray-800 rounded-lg group-hover:bg-blue-600/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span>Email</span>
                    </a>
                    
                    <a href="tel:+260971863462" class="group flex items-center gap-2 hover:text-blue-400 transition-all duration-200 text-sm font-medium" aria-label="Call">
                        <div class="p-2 bg-gray-800 rounded-lg group-hover:bg-blue-600/10 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <span>Call</span>
                    </a>
                    
                    <a href="https://www.linkedin.com/in/kundananji-simukonda" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2 hover:text-blue-400 transition-all duration-200 text-sm font-medium" aria-label="LinkedIn">
                        <div class="p-2 bg-gray-800 rounded-lg group-hover:bg-blue-600/10 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.25c-.97 0-1.75-.78-1.75-1.75s.78-1.75 1.75-1.75 1.75.78 1.75 1.75-.78 1.75-1.75 1.75zm13.5 11.25h-3v-5.5c0-1.38-1.12-2.5-2.5-2.5s-2.5 1.12-2.5 2.5v5.5h-3v-10h3v1.4c.8-1.2 2.5-1.4 3.5-.2 1 1.2 1 3 1 3v5.8z"/>
                            </svg>
                        </div>
                        <span>LinkedIn</span>
                    </a>
                    
                    <a href="https://github.com/Kundananjik" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-2 hover:text-blue-400 transition-all duration-200 text-sm font-medium" aria-label="GitHub">
                        <div class="p-2 bg-gray-800 rounded-lg group-hover:bg-blue-600/10 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.418-1.305.762-1.604-2.665-.3-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.523.117-3.176 0 0 1.008-.322 3.301 1.23a11.52 11.52 0 013.003-.404c1.018.005 2.042.138 3.003.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.873.118 3.176.77.84 1.235 1.912 1.235 3.222 0 4.61-2.804 5.625-5.476 5.922.43.372.815 1.102.815 2.222 0 1.606-.015 2.896-.015 3.286 0 .32.218.694.825.576 4.765-1.588 8.199-6.084 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </div>
                        <span>GitHub</span>
                    </a>   
                </div>
            </div>
        </div>
    </footer>

</body>
</html>