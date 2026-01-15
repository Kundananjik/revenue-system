{{-- resources/views/privacy.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Privacy Policy | Revenue System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50/30 text-gray-800 antialiased">

    <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200/60 py-4 px-6 sticky top-0 z-50 shadow-sm">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">R</div>
                <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">
                    Revenue System
                </span>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    @php
                        $dashboardUrl = route('user.dashboard');

                        $user = auth()->user();
                        if (method_exists($user, 'hasRole')) {
                            if ($user->hasRole('collector')) $dashboardUrl = route('collector.dashboard');
                            if ($user->hasAnyRole(['admin', 'super-admin'])) $dashboardUrl = route('admin.dashboard');
                        }
                    @endphp

                    <a href="{{ $dashboardUrl }}" class="text-gray-700 hover:text-blue-600 font-semibold transition-colors duration-200">
                        Dashboard
                    </a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-semibold px-4 py-2 rounded-lg transition-all duration-200 hover:bg-gray-50">
                            Log in
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-12">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100/60">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Privacy Policy</h1>
                <p class="text-sm text-gray-500 mt-2">
                    Last updated: {{ date('F j, Y') }}
                </p>
            </div>

            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed">
                    This Privacy Policy explains how <span class="font-semibold">Revenue System</span> collects, uses, stores, and protects information when you use the platform.
                    The platform is designed for revenue tracking, user role management, and reporting.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8">1. Information We Collect</h2>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li><span class="font-semibold">Account information</span> such as name, email address, role, and authentication details.</li>
                    <li><span class="font-semibold">Payment records</span> such as amounts, status (pending, paid, failed, reversed), references, and timestamps.</li>
                    <li><span class="font-semibold">System activity</span> such as login events and actions performed (where audit logging is enabled).</li>
                    <li><span class="font-semibold">Technical data</span> such as device, browser, and IP information for security and troubleshooting.</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8">2. How We Use Information</h2>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>To authenticate users and enforce role based access control.</li>
                    <li>To process and manage revenue and payment records.</li>
                    <li>To generate reports and support audits and accountability.</li>
                    <li>To detect fraud, abuse, unauthorized access, and system errors.</li>
                    <li>To improve reliability, performance, and user experience.</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8">3. Data Retention</h2>
                <p class="text-gray-700 leading-relaxed">
                    Records may be retained as long as required for operational, reporting, audit, and legal purposes.
                    Administrators may export reports to PDF or Excel as provided by the platform.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8">4. Data Security</h2>
                <p class="text-gray-700 leading-relaxed">
                    We apply reasonable technical and organizational safeguards to protect data against loss, misuse, and unauthorized access.
                    However, no online system can guarantee absolute security.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8">5. Sharing and Disclosure</h2>
                <p class="text-gray-700 leading-relaxed">
                    Revenue System does not sell personal data. Information may be shared only when needed to operate the platform, comply with legal obligations, enforce policies, or protect users and the system.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8">6. Your Responsibilities</h2>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Keep your credentials confidential.</li>
                    <li>Use strong passwords and log out on shared devices.</li>
                    <li>Report suspected unauthorized activity to the system administrator.</li>
                </ul>

                <h2 class="text-xl font-bold text-gray-900 mt-8">7. Changes to This Policy</h2>
                <p class="text-gray-700 leading-relaxed">
                    This policy may be updated to reflect improvements or compliance requirements. Updates will be posted on this page with a revised date.
                </p>

                <h2 class="text-xl font-bold text-gray-900 mt-8">8. Contact</h2>
                <p class="text-gray-700 leading-relaxed">
                    For privacy questions, contact:
                    <span class="font-semibold">Kundananji Simukonda</span><br>
                    Email: <a class="text-blue-600 hover:text-blue-700 font-semibold" href="mailto:kundananjisimukonda@gmail.com">kundananjisimukonda@gmail.com</a><br>
                    Phone: <a class="text-blue-600 hover:text-blue-700 font-semibold" href="tel:+260971863462">+260971863462</a>
                </p>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Back to Home</a>
                <a href="{{ url('/terms') }}" class="text-gray-700 hover:text-blue-600 font-semibold">Terms of Use</a>
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

                    <p class="text-xs text-gray-600 mt-3">
                        <a href="{{ url('/privacy') }}" class="hover:text-blue-400 transition-colors">Privacy Policy</a>
                        <span class="mx-2">|</span>
                        <a href="{{ url('/terms') }}" class="hover:text-blue-400 transition-colors">Terms of Use</a>
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
