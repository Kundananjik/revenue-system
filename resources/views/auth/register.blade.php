<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Revenue System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        
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
                <p class="text-gray-500 text-sm mt-1">Create your account</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded p-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus 
                        placeholder="Full name"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="name@email.com"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        placeholder="••••••••"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 border"
                    >
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                        Already have an account?
                    </a>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200"
                >
                    Create Account
                </button>
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
