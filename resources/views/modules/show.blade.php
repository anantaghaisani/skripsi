@extends('layouts.app')

@section('title', $module->title)
@section('page-title', 'Detail Modul')

@section('content')
<div class="p-8">
    <div class="max-w-5xl mx-auto">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('modules.index') }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Modul
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    
                    <!-- Thumbnail -->
                    @if($module->thumbnail)
                        <img src="{{ asset('storage/' . $module->thumbnail) }}" 
                             alt="{{ $module->title }}"
                             class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gradient-to-r from-purple-600 to-indigo-600 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="p-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $module->title }}</h1>

                        @if($module->description)
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $module->description }}</p>
                            </div>
                        @endif

                        <!-- File Info Card -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h3 class="text-sm font-semibold text-gray-900 mb-3">Informasi File</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Tipe File</p>
                                    <p class="text-sm font-semibold text-gray-900 uppercase">{{ $module->file_type }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Ukuran File</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ number_format($module->file_size / 1024 / 1024, 2) }} MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-4">
                            @if(in_array($module->file_type, ['pdf']))
                                <a href="{{ route('modules.view-pdf', $module->id) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview
                                </a>
                            @endif
                            <a href="{{ route('modules.download-pdf', $module->id) }}" 
                               class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-lg transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Module Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Modul</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <div>
                                <p class="text-gray-500">Dibuat oleh</p>
                                <p class="font-semibold text-gray-900">{{ $module->creator->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-gray-500">Dibuat</p>
                                <p class="font-semibold text-gray-900">{{ $module->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-gray-500">Terakhir diubah</p>
                                <p class="font-semibold text-gray-900">{{ $module->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Classes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Kelas yang Dapat Mengakses</h3>
                    <div class="space-y-2">
                        @foreach($module->classes as $class)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">{{ $class->full_name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection