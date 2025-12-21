<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tentor - Hakuna Matata Course')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'hm-blue': '#184E83',
                        'hm-yellow': '#FFC107',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-56 bg-white shadow-lg flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b flex justify-center">
                <img src="{{ asset('images/logo_hmc.png') }}" alt="HM Logo" class="h-12 mt-2">
            </div>

            <!-- Menu Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('tentor.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                   {{ Request::is('tentor/dashboard*') ? 'bg-hm-blue text-white' : 'text-gray-400 hover:bg-gray-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- Tryout -->
                <a href="{{ route('tentor.tryout.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                   {{ Request::is('tentor/tryout*') ? 'bg-hm-blue text-white' : 'text-gray-400 hover:bg-gray-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium">Tryout</span>
                </a>

                <!-- Modul -->
                <a href="{{ route('tentor.module.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                   {{ Request::is('tentor/module*') ? 'bg-hm-blue text-white' : 'text-gray-400 hover:bg-gray-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="font-medium">Modul Pembelajaran</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('tentor.profile.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg 
                   {{ Request::is('tentor/profile*') ? 'bg-hm-blue text-white' : 'text-gray-400 hover:bg-gray-50' }} transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">Profile</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar (Transparent) -->
            <header class="px-8 py-4 bg-transparent transition-all duration-300">
                <div class="flex items-center justify-between">
                    <!-- Page Title -->
                    <h1 class="text-3xl font-bold text-hm-blue">
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <!-- User Profile Section -->
                    <div class="flex items-center space-x-4">
                        <!-- User Info -->
                        <div class="flex items-center space-x-3 px-4 py-2 bg-white rounded-full shadow-sm">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="w-10 h-10 rounded-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=184E83&color=fff" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="w-10 h-10 rounded-full">
                            @endif
                            
                            <div class="leading-tight">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ Auth::user()->name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="p-3 bg-white rounded-full shadow-sm text-gray-400 hover:text-red-600 transition"
                                    title="Logout">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>