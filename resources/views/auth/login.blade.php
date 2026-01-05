<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Revenue System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex flex-col">

    <div class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-blue-600">Revenue System</h1>
                <p class="text-gray-500 text-sm mt-1">Sign in to your account</p>
            </div>

            @if(old('email'))
                @php
                    $user = \App\Models\User::where('email', old('email'))->first();
                @endphp

                @if($user && ($user->role === 'admin' || $user->role === 'super-admin'))
                    <div class="mb-4 text-sm text-blue-700 bg-blue-50 border border-blue-200 rounded p-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        Admin login detected: you will be redirected to the admin dashboard after login.
                    </div>
                @endif
            @endif

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded p-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                        placeholder="you@example.com"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                        <span class="ml-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200"
                >
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <footer class="bg-gray-900 text-gray-400 py-6 px-4 border-t border-gray-800 w-full">
        <div class="max-w-7xl mx-auto flex flex-col items-center justify-center space-y-4">
            <div class="text-center text-sm">
                &copy; {{ date('Y') }} <span class="font-bold text-white">Revenue System</span> Developed by 
                <span class="text-blue-400 font-medium">Kundananji Simukonda</span>
            </div>

            <div class="flex flex-wrap justify-center gap-4 md:gap-6 text-xs font-medium items-center">
                <a href="mailto:kundananjisimukonda@gmail.com" class="flex items-center hover:text-blue-400 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Email
                </a>
                <a href="tel:+260971863462" class="flex items-center hover:text-blue-400 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    Call
                </a>
                <a href="https://www.linkedin.com/in/kundananji-simukonda" target="_blank" class="flex items-center hover:text-blue-400 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.25c-.97 0-1.75-.78-1.75-1.75s.78-1.75 1.75-1.75 1.75.78 1.75 1.75-.78 1.75-1.75 1.75zm13.5 11.25h-3v-5.5c0-1.38-1.12-2.5-2.5-2.5s-2.5 1.12-2.5 2.5v5.5h-3v-10h3v1.4c.8-1.2 2.5-1.4 3.5-.2 1 1.2 1 3 1 3v5.8z"/></svg>
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

</body>
</html>