<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Revenue System</title>
    <script src="https://cdn.tailwindcss.com"></script>
        
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

</head>
<body class="min-h-screen bg-gray-100 flex flex-col">

    <nav class="bg-white border-b border-gray-200 py-3 px-6 shadow-sm">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">R</div>
                <span class="font-bold text-gray-800 hidden sm:block">Revenue System</span>
            </div>
            
            <a href="{{ url('/') }}" class="flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Home
            </a>
        </div>
    </nav>

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
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
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

                @if (Route::has('register'))
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Register</a>
                        </p>
                    </div>
                @endif
            </form>
        </div>
    </div>

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

</body>
</html>