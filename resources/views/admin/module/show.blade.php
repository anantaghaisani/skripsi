@extends('admin.layouts.app')

@section('title', 'Detail Modul - ' . $module->title)

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.module.index'),
        'previousPage' => 'Kelola Modul',
        'currentPage' => $module->title
    ])
@endsection

@section('content')
<div class="p-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Module Preview -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Module Cover/Thumbnail -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @if($module->thumbnail)
                    <img src="{{ asset('storage/' . $module->thumbnail) }}" 
                         alt="{{ $module->title }}" 
                         class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gradient-to-br from-red-600 to-red-800 flex items-center justify-center">
                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Module Content -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                @if($module->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $module->description }}</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    @if($module->file_type === 'pdf' && $module->file_path)
                        <a href="{{ asset('storage/' . $module->file_path) }}" 
                           target="_blank"
                           class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-center">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat PDF
                        </a>
                    @endif
                    
                    @if($module->file_path)
                        <a href="{{ asset('storage/' . $module->file_path) }}" 
                           download
                           class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition text-center">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download
                        </a>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right: Module Info -->
        <div class="space-y-6">
            
            <!-- Informasi Modul -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Modul</h3>
                
                <div class="space-y-4">
                    <!-- Dibuat oleh -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Dibuat oleh</span>
                        </div>
                        <p class="font-semibold text-gray-900 ml-7">{{ $module->creator->name }}</p>
                        <p class="text-xs text-gray-500 ml-7">{{ ucfirst($module->creator->role) }}</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Status</span>
                        </div>
                        <div class="ml-7">
                            @if($module->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Dibuat -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Dibuat</span>
                        </div>
                        <p class="font-semibold text-gray-900 ml-7">{{ $module->created_at->format('d M Y') }}</p>
                    </div>

                    <!-- Terakhir diubah -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Terakhir diubah</span>
                        </div>
                        <p class="font-semibold text-gray-900 ml-7">{{ $module->updated_at->format('d M Y') }}</p>
                    </div>

                    <!-- File Info -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span>Tipe File</span>
                        </div>
                        <p class="font-semibold text-gray-900 ml-7 uppercase">{{ $module->file_type }}</p>
                    </div>

                    <!-- File Size -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                            </svg>
                            <span>Ukuran</span>
                        </div>
                        <p class="font-semibold text-gray-900 ml-7">{{ number_format($module->file_size / 1024 / 1024, 2) }} MB</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 pt-6 border-t space-y-2">
                    <a href="{{ route('admin.module.edit', $module->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Modul
                    </a>
                    
                    <form action="{{ route('admin.module.toggle-status', $module->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 {{ $module->is_active ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-semibold rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($module->is_active)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @endif
                            </svg>
                            {{ $module->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.module.destroy', $module->id) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus modul ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Modul
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kelas yang Dapat Mengakses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Kelas yang Dapat Mengakses</h3>
                
                <div class="flex flex-wrap gap-2">
                    @forelse($module->classes as $class)
                        <span class="px-3 py-2 bg-purple-100 text-purple-700 text-sm font-semibold rounded-lg flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $class->full_name }}
                        </span>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada kelas yang dapat mengakses</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection