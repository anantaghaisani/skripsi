@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl p-6 text-white">
            <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-red-100">Dashboard overview sistem Hakuna Matata Course</p>
        </div>

        <!-- Main Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">Active</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_users'] }}</h3>
                <p class="text-sm text-gray-600">Total Users</p>
            </div>

            <!-- Total Classes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-school text-purple-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_classes'] }}</h3>
                <p class="text-sm text-gray-600">Total Kelas</p>
            </div>

            <!-- Total Tryouts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-green-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $stats['active_tryouts'] }} Active</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_tryouts'] }}</h3>
                <p class="text-sm text-gray-600">Total Tryout</p>
            </div>

            <!-- Total Modules -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $stats['active_modules'] }} Active</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_modules'] }}</h3>
                <p class="text-sm text-gray-600">Total Modul</p>
            </div>
        </div>

        <!-- User Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Students</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tentors</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_tentors'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Admins</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_admins'] }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-shield text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">👥 Recent Users</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                        Lihat Semua →
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex items-center space-x-3">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=40&background=random" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role === 'student' ? 'bg-blue-100 text-blue-700' : ($user->role === 'tentor' ? 'bg-purple-100 text-purple-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada user</p>
                    @endforelse
                </div>
            </div>

            <!-- Popular Tryouts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">🔥 Popular Tryouts</h3>
                    <a href="{{ route('admin.tryout.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                        Lihat Semua →
                    </a>
                </div>
                <div class="space-y-3">
                    @forelse($tryoutStats as $tryout)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $tryout->title }}</p>
                                <p class="text-xs text-gray-500">{{ $tryout->total_participants }} participants</p>
                            </div>
                            <div class="text-right">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">{{ $tryout->total_participants }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada tryout</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Class Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">🏫 Distribusi Kelas</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse($classStats as $class)
                    <div class="border border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 transition">
                        <p class="font-bold text-gray-900 text-lg">{{ $class->full_name }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $class->students_count }} siswa</p>
                    </div>
                @empty
                    <p class="col-span-full text-gray-500 text-sm text-center py-4">Belum ada kelas</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection