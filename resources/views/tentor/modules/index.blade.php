@extends('tentor.layouts.app')

@section('title', 'Daftar Modul')
@section('page-title', 'Daftar Modul')

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Search Bar + Filter + Button -->
        <form method="GET" class="mb-6 flex items-center gap-4">
            
            <!-- Search Bar -->
            <div class="flex-1">
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari"
                           class="w-full h-12 pl-11 pr-4
                                  bg-white rounded-full shadow-sm
                                  border border-gray-200
                                  text-sm
                                  focus:ring-2 focus:ring-[#184E83]
                                  focus:border-transparent">
                </div>
            </div>

            <!-- Filter Dropdown -->
            <div class="relative">
                <select name="class_id"
                        onchange="this.form.submit()"
                        class="h-12 px-5 pr-10
                               bg-white rounded-full shadow-sm
                               border border-gray-200
                               text-sm text-gray-600
                               focus:ring-2 focus:ring-[#184E83]
                               focus:border-transparent
                               appearance-none cursor-pointer">
                    <option value="">Semua Kelas</option>
                    @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}"
                            {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->full_name }}
                        </option>
                    @endforeach
                </select>

                <!-- Dropdown icon -->
                <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

            <!-- Add Module Button -->
            <a href="{{ route('tentor.modules.create') }}"
               class="h-12 px-6
                      bg-[#184E83] hover:bg-[#123b63]
                      text-white text-sm font-semibold
                      rounded-full shadow-sm
                      flex items-center gap-2 transition">
                <span class="text-lg leading-none">+</span>
                Modul
            </a>
            
        </form>

        <!-- Segmented Control (3 tabs) -->
        <div class="mb-6">
            <div class="flex bg-white rounded-xl shadow-sm overflow-hidden">

                <!-- Tab: Semua -->
                <a href="{{ route('tentor.modules.index', request()->except('is_active')) }}"
                   class="flex-1 py-4 px-6 text-center text-sm transition
                   {{ !request()->has('is_active')
                        ? 'font-semibold text-[#184E83] border-b-4 border-[#FFBF00]'
                        : 'font-medium text-gray-400 hover:text-gray-600' }}">
                    Semua
                </a>

                <!-- Tab: Aktif -->
                <a href="{{ route('tentor.modules.index', array_merge(request()->except('is_active'), ['is_active' => '1'])) }}"
                   class="flex-1 py-4 px-6 text-center text-sm transition
                   {{ request('is_active') === '1'
                        ? 'font-semibold text-[#184E83] border-b-4 border-[#FFBF00]'
                        : 'font-medium text-gray-400 hover:text-gray-600' }}">
                    Aktif
                </a>

                <!-- Tab: Non Aktif -->
                <a href="{{ route('tentor.modules.index', array_merge(request()->except('is_active'), ['is_active' => '0'])) }}"
                   class="flex-1 py-4 px-6 text-center text-sm transition
                   {{ request('is_active') === '0'
                        ? 'font-semibold text-[#184E83] border-b-4 border-[#FFBF00]'
                        : 'font-medium text-gray-400 hover:text-gray-600' }}">
                    Non Aktif
                </a>

            </div>
        </div>

        <!-- Modules Table -->
        @if($modules->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Modul</h3>
                <p class="text-gray-600 mb-6">Mulai buat modul pembelajaran pertama Anda</p>
                <a href="{{ route('tentor.modules.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-[#184E83] hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Modul
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                @if(!request()->has('is_active'))
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                @endif
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($modules as $module)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $module->title }}</div>
                                                <div class="text-xs text-gray-500 mt-1">{{ $module->file_type }} • {{ number_format($module->file_size / 1024 / 1024, 2) }} MB</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($module->classes->take(2) as $class)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ $class->grade_level }} {{ $class->class_number }}
                                                </span>
                                            @endforeach
                                            @if($module->classes->count() > 2)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                    +{{ $module->classes->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    @if(!request()->has('is_active'))
                                        <td class="px-6 py-4">
                                            @if($module->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- View -->
                                            <div class="relative group">
                                                <a href="{{ route('tentor.modules.show', $module->id) }}" 
                                                   class="inline-flex items-center justify-center w-9 h-9 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                    Lihat Detail
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit -->
                                            <div class="relative group">
                                                <a href="{{ route('tentor.modules.edit', $module->id) }}" 
                                                   class="inline-flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                    Edit
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Toggle Status -->
                                            <form action="{{ route('tentor.modules.toggle-status', $module->id) }}" method="POST" class="relative group">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center justify-center w-9 h-9 {{ $module->is_active ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg transition">
                                                    @if($module->is_active)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @endif
                                                </button>
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                    {{ $module->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                                    </div>
                                                </div>
                                            </form>

                                            <!-- Hapus -->
                                            <form action="{{ route('tentor.modules.destroy', $module->id) }}" method="POST" class="relative group">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus modul ini?')"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                    Hapus
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($modules->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $modules->links() }}
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection