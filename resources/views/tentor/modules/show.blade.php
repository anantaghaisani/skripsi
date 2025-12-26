@extends('tentor.layouts.app')

@section('title', $module->title . ' - Hakuna Matata Course')

@section('breadcrumb')
    @include('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.modules.index'),
        'previousPage' => 'Kelola Modul',
        'currentPage' => 'Detail Modul'
    ])
@endsection

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">

        <!-- Header Actions -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $module->title }}</h2>
                <p class="text-gray-600 mt-1">{{ $module->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('tentor.modules.edit', $module->id) }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Modul
                </a>
                <form action="{{ route('tentor.modules.destroy', $module->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus modul ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Modul
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Module Preview -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    @if($module->thumbnail)
                        <img src="{{ asset('storage/' . $module->thumbnail) }}" 
                             alt="{{ $module->title }}"
                             class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gradient-to-r from-blue-600 to-indigo-600 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $module->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $module->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $module->created_at->diffForHumans() }}
                            </div>
                        </div>

                        @if($module->description)
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2">Deskripsi</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $module->description }}</p>
                            </div>
                        @endif

                        <!-- File Info -->
                        <div class="bg-gray-50 rounded-lg p-4">
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
                            <a href="{{ asset('storage/' . $module->file_path) }}" 
                               target="_blank"
                               class="mt-4 block w-full text-center px-4 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Unduh / Preview File
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Classes with Access -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Kelas yang Dapat Mengakses</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($module->classes as $class)
                            <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">{{ $class->full_name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Module Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Modul</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Dibuat oleh</span>
                            <span class="font-semibold text-gray-900">{{ $module->creator->name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Dibuat</span>
                            <span class="font-semibold text-gray-900">{{ $module->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-gray-600">Terakhir diubah</span>
                            <span class="font-semibold text-gray-900">{{ $module->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('tentor.modules.edit', $module->id) }}" 
                           class="flex items-center w-full px-4 py-3 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="font-medium">Edit Modul</span>
                        </a>
                        <a href="{{ asset('storage/' . $module->file_path) }}" 
                           target="_blank"
                           class="flex items-center w-full px-4 py-3 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span class="font-medium">Unduh File</span>
                        </a>
                        <button onclick="copyLink()" 
                                class="flex items-center w-full px-4 py-3 text-left text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span class="font-medium">Salin Link</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
function copyLink() {
    const url = "{{ route('tentor.modules.show', $module->id) }}";
    navigator.clipboard.writeText(url).then(() => {
        alert('Link berhasil disalin!');
    });
}
</script>
@endpush
@endsection