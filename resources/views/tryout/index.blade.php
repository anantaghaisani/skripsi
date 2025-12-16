@extends('layouts.app')

@section('title', 'Tryout - HM App')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Menu</h2>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span class="text-sm">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('tryout.index') }}" class="flex items-center space-x-3 px-4 py-2 bg-blue-600 text-white rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Tryout</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span class="text-sm">Modul Pembelajaran</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-sm">Profile</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 ml-8">
                <div class="bg-white rounded-lg shadow-sm">
                    <!-- Header -->
                    <div class="border-b border-gray-200">
                        <div class="flex items-center justify-between px-6 py-4">
                            <h1 class="text-2xl font-bold text-gray-900">Tryout</h1>
                        </div>
                        <div class="flex border-b border-gray-200">
                            <button class="px-6 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                                Belum Dikerjakan
                            </button>
                            <button class="px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                                Sudah Dikerjakan
                            </button>
                        </div>
                    </div>

                    <!-- Tryout List -->
                    <div class="p-6">
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="space-y-4">
                            @forelse($tryouts as $tryout)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="bg-blue-50 p-3 rounded-lg">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 mb-1">{{ $tryout->code }}</p>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $tryout->title }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                <span>{{ $tryout->start_date->format('d F Y') }} - {{ $tryout->end_date->format('d F Y') }}</span>
                                                <span>•</span>
                                                <span>{{ $tryout->total_questions }} soal</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @php
                                            $userTryout = $tryout->users->first();
                                            $status = $userTryout ? $userTryout->pivot->status : 'belum_dikerjakan';
                                        @endphp

                                        @if($status == 'sudah_dikerjakan')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                        @elseif($status == 'sedang_dikerjakan')
                                            <a href="{{ route('tryout.work', $tryout->id) }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                                Lanjutkan
                                            </a>
                                        @else
                                            <form action="{{ route('tryout.start', $tryout->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-400 text-gray-900 text-sm font-medium rounded-lg hover:bg-yellow-500 transition">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                    </svg>
                                                    Kerjakan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada tryout</h3>
                                <p class="mt-1 text-sm text-gray-500">Belum ada tryout yang tersedia saat ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
