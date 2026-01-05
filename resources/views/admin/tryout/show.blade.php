@extends('admin.layouts.app')

@section('title', 'Detail Tryout - ' . $tryout->title)

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.tryout.index'),
        'previousPage' => 'Kelola Tryout',
        'currentPage' => $tryout->title
    ])
@endsection

@section('content')
<div class="p-8">

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Tryout Info -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Tryout Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $tryout->title }}</h3>
                
                @if($tryout->description)
                    <p class="text-gray-600 mb-6">{{ $tryout->description }}</p>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-xs text-blue-600 font-medium mb-1">Total Soal</div>
                        <div class="text-2xl font-bold text-blue-900">{{ $tryout->total_questions }}</div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="text-xs text-purple-600 font-medium mb-1">Durasi</div>
                        <div class="text-2xl font-bold text-purple-900">{{ $tryout->duration_minutes }}<span class="text-sm ml-1">menit</span></div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-xs text-green-600 font-medium mb-1">Peserta</div>
                        <div class="text-2xl font-bold text-green-900">{{ $tryout->participants ? $tryout->participants->count() : 0 }}</div>
                    </div>
                    
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="text-xs text-yellow-600 font-medium mb-1">Selesai</div>
                        <div class="text-2xl font-bold text-yellow-900">{{ $tryout->participants ? $tryout->participants()->wherePivot('status', 'completed')->count() : 0 }}</div>
                    </div>
                </div>

                <!-- Questions List -->
                <div class="border-t pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-gray-900">Daftar Soal ({{ $tryout->questions->count() }})</h4>
                        <a href="{{ route('admin.question.index', $tryout->id) }}" 
                           class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Kelola Soal
                        </a>
                    </div>

                    @forelse($tryout->questions as $index => $question)
                        <div class="flex items-start p-4 border-b last:border-b-0 hover:bg-gray-50 transition">
                            <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-sm font-bold text-red-600">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium mb-2">{{ $question->question_text }}</p>
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span>Bobot: {{ $question->points }}</span>
                                    <span>Jawaban: {{ $question->correct_answer }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="font-medium">Belum ada soal</p>
                            <p class="text-sm text-gray-400 mt-1">Tambahkan soal untuk tryout ini</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Sidebar -->
        <div class="space-y-6">
            
            <!-- Tryout Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Tryout</h3>
                
                <div class="space-y-4">
                    <!-- Creator -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Dibuat oleh</span>
                        </div>
                        @if($tryout->creator)
                            <p class="font-semibold text-gray-900 ml-7">{{ $tryout->creator->name }}</p>
                            <p class="text-xs text-gray-500 ml-7">{{ ucfirst($tryout->creator->role) }}</p>
                        @else
                            <p class="text-sm text-gray-400 italic ml-7">Creator dihapus</p>
                        @endif
                    </div>

                    <!-- Code -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            <span>Kode</span>
                        </div>
                        <p class="font-semibold text-gray-900 ml-7">{{ $tryout->code }}</p>
                    </div>

                    <!-- Token -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            <span>Token</span>
                        </div>
                        <p class="font-mono font-semibold text-gray-900 ml-7">{{ $tryout->token }}</p>
                    </div>

                    <!-- Date -->
                    <div>
                        <div class="flex items-center text-sm text-gray-600 mb-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Periode</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-900 ml-7">
                            {{ $tryout->start_date->format('d M Y') }} - {{ $tryout->end_date->format('d M Y') }}
                        </p>
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
                            @if($tryout->is_active)
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
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 pt-6 border-t space-y-2">
                    <a href="{{ route('admin.tryout.monitor', $tryout->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Monitor Tryout
                    </a>

                    <a href="{{ route('admin.tryout.edit', $tryout->id) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Tryout
                    </a>

                    <form action="{{ route('admin.tryout.destroy', $tryout->id) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus tryout ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Tryout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Classes Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Kelas yang Dapat Mengakses</h3>
                
                <div class="flex flex-wrap gap-2">
                    @forelse($tryout->classes as $class)
                        <span class="px-3 py-2 bg-purple-100 text-purple-700 text-sm font-semibold rounded-lg">
                            {{ $class->full_name }}
                        </span>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada kelas</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection