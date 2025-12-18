<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tryout App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="bg-yellow-400 rounded-lg p-2">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">HM</span>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('tryout.index') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 {{ Request::is('tryout*') ? 'border-blue-500 text-blue-600' : 'border-transparent' }}">
                        Tryout
                    </a>
                    <a href="#" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent">
                        Modul Pembelajaran
                    </a>
                    <a href="#" class="text-gray-700 hover:text-gray-900 px-3 py-2 text-sm font-medium border-b-2 border-transparent">
                        Profile
                    </a>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-4">
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </button>
                    <div class="flex items-center space-x-2">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=random" alt="Profile" class="w-8 h-8 rounded-full">
                        <div class="text-sm">
                            <p class="font-medium text-gray-900">{{ Auth::user()->name ?? 'Hakuna' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'user@gmail.com' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
