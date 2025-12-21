@extends('tentor.layout')

@section('title', 'Dashboard Tentor - Hakuna Matata Course')
@section('page-title', 'Dashboard')

@section('content')
<div class="p-8 space-y-6">

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-[#184E83] via-blue-600 to-indigo-700 rounded-xl p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ $tentor->name }}! 👋</h2>
        <p class="text-blue-100">Kelola tryout dan modul pembelajaran untuk siswa Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tryouts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Tryout</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $stats['total_tryouts'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Yang sudah dibuat</p>
        </div>

        <!-- Active Tryouts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Tryout Aktif</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $stats['active_tryouts'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Sedang berjalan</p>
        </div>

        <!-- Total Modules -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Modul</p>
                    <h3 class="text-3xl font-bold text-purple-600">{{ $stats['total_modules'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Yang sudah dibuat</p>
        </div>

        <!-- Total Students -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-yellow-600">{{ $stats['total_students'] }}</h3>
                </div>
                <div class="w-14 h-14 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Terdaftar di sistem</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Recent Tryouts & Modules -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Recent Tryouts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">📝 Tryout Terbaru</h2>
                    <a href="{{ route('tentor.tryout.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                @if($recentTryouts->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-3">Belum ada tryout</p>
                        <a href="{{ route('tentor.tryout.create') }}" class="inline-flex items-center px-4 py-2 bg-hm-blue text-white rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Buat Tryout
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentTryouts as $tryout)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $tryout->title }}</h4>
                                    <p class="text-xs text-gray-500">Token: <span class="font-mono font-bold text-blue-600">{{ $tryout->token }}</span></p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">{{ $tryout->classes->count() }} kelas</span>
                                        <span class="text-xs text-gray-500">{{ $tryout->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('tentor.tryout.monitor', $tryout->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                                    Monitor
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Recent Modules -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">📚 Modul Terbaru</h2>
                    <a href="{{ route('tentor.module.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                @if($recentModules->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-3">Belum ada modul</p>
                        <a href="{{ route('tentor.module.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Upload Modul
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentModules as $module)
                            <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $module->title }}</h4>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">{{ $module->subject }}</span>
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded">{{ $module->classes->count() }} kelas</span>
                                    <span class="text-xs text-gray-500">{{ $module->views }} views</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <!-- Right: Popular Tryouts -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">🔥 Tryout Populer</h2>

                @if($popularTryouts->isEmpty())
                    <p class="text-center text-gray-500 py-8">Belum ada data</p>
                @else
                    <div class="space-y-3">
                        @foreach($popularTryouts as $item)
                            <div class="p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg">
                                <h4 class="font-semibold text-gray-900 text-sm mb-2">{{ $item['tryout']->title }}</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-600">{{ $item['completed_count'] }} siswa</span>
                                    <span class="text-sm font-bold text-green-600">{{ $item['completion_rate'] }}%</span>
                                </div>
                                <div class="mt-2 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $item['completion_rate'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">🚀 Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('tentor.tryout.create') }}" class="block w-full py-3 px-4 bg-white hover:bg-gray-50 text-gray-900 font-medium rounded-lg transition text-center shadow-sm">
                        + Buat Tryout Baru
                    </a>
                    <a href="{{ route('tentor.module.create') }}" class="block w-full py-3 px-4 bg-white hover:bg-gray-50 text-gray-900 font-medium rounded-lg transition text-center shadow-sm">
                        + Upload Modul Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection