@extends('layouts.app')

@section('title', 'Modul Pembelajaran - Hakuna Matata Course')
@section('page-title', 'Modul Pembelajaran')

@section('content')
<div class="p-8">
    <!-- Header Info -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">
                    Modul untuk {{ $user->grade_level ?? 'Semua Jenjang' }} 
                    @if($user->class_number)
                        - Kelas {{ $user->class_number }}
                    @endif
                </h2>
                <p class="text-sm text-gray-600">
                    Total {{ $modules->count() }} modul pembelajaran tersedia
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>

    @if($modules->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Modul</h3>
            <p class="text-sm text-gray-500">Modul pembelajaran untuk kelasmu akan segera tersedia.</p>
        </div>
    @else
        <!-- Modules Grid - 3 Columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($modules as $module)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <!-- Cover Image -->
                    <div class="relative h-48 bg-gradient-to-br from-blue-500 to-indigo-600 overflow-hidden">
                        @if($module->cover_image && file_exists(public_path('storage/' . $module->cover_image)))
                            <img src="{{ asset('storage/' . $module->cover_image) }}" 
                                 alt="{{ $module->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <!-- Default gradient with subject icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-16 h-16 mx-auto mb-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p class="text-sm font-semibold opacity-80">{{ $module->subject }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-semibold text-gray-700 rounded-full">
                                Kelas {{ $module->class_number }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <!-- Subject Badge -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded">
                                {{ $module->subject }}
                            </span>
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $module->views }} views
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                            {{ $module->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $module->description }}
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('modules.view-pdf', $module->id) }}" 
                               target="_blank"
                               class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-[#184E83] hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat PDF
                            </a>
                            <a href="{{ route('modules.download-pdf', $module->id) }}" 
                               class="inline-flex items-center justify-center px-3 py-2.5 border border-gray-300 hover:border-gray-400 text-gray-700 text-sm font-semibold rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
@endsection