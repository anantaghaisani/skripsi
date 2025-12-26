@extends('layouts.app')

@section('title', 'Daftar Tryout - Hakuna Matata Course')
@section('page-title', 'Daftar Tryout')

@section('content')
<div class="p-8">
    <!-- Tabs -->
    <div class="mb-6">
        <div class="flex bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Active Tab: Belum Dikerjakan -->
            <button 
                id="tab-belum"
                onclick="switchTab('belum')"
                class="w-1/2 py-4 px-6 text-sm font-semibold text-[#184E83] border-b-4 border-[#FFBF00] transition">
                Belum Dikerjakan
            </button>

            <!-- Inactive Tab: Sudah Dikerjakan -->
            <button 
                id="tab-sudah"
                onclick="switchTab('sudah')"
                class="w-1/2 py-4 px-6 text-sm font-medium text-gray-400 hover:text-gray-600 transition">
                Sudah Dikerjakan
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Content: Belum Dikerjakan -->
    <div id="content-belum">
        @php
            $belumDikerjakan = $tryouts->filter(function($tryout) use ($completedTryoutIds) {
                return !in_array($tryout->id, $completedTryoutIds);
            });
        @endphp

        @if($belumDikerjakan->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Tryout</h3>
                <p class="text-gray-600">Tryout yang belum dikerjakan akan muncul di sini</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($belumDikerjakan as $tryout)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition overflow-hidden">
                        <!-- Header with Gradient -->
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold mb-1">{{ $tryout->title }}</h3>
                                    <p class="text-blue-100 text-sm">{{ $tryout->code }}</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500 text-white">
                                    Tersedia
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-blue-100 text-xs mb-1">Jumlah Soal</p>
                                    <p class="text-2xl font-bold">{{ $tryout->questions->count() }}</p>
                                </div>
                                <div>
                                    <p class="text-blue-100 text-xs mb-1">Durasi</p>
                                    <p class="text-2xl font-bold">{{ $tryout->duration_minutes }} <span class="text-sm">menit</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="p-6">
                            <!-- Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $tryout->start_date->format('d M Y') }} - {{ $tryout->end_date->format('d M Y') }}</span>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span>{{ $tryout->classes->pluck('full_name')->join(', ') }}</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('tryout.show', $tryout->id) }}" 
                               class="block w-full text-center px-6 py-3 bg-[#FFC107] hover:bg-yellow-500 text-gray-900 font-semibold rounded-lg transition">
                                Kerjakan
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Content: Sudah Dikerjakan (Hidden by default) -->
    <div id="content-sudah" class="hidden">
        @php
            $sudahDikerjakan = $tryouts->filter(function($tryout) use ($completedTryoutIds) {
                return in_array($tryout->id, $completedTryoutIds);
            });
        @endphp

        @if($sudahDikerjakan->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Tryout yang Selesai</h3>
                <p class="text-gray-600">Tryout yang sudah kamu kerjakan akan muncul di sini</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($sudahDikerjakan as $tryout)
                    @php
                        $userTryout = Auth::user()->tryouts()->where('tryout_id', $tryout->id)->first();
                        $score = $userTryout ? $userTryout->pivot->score : 0;
                    @endphp
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition overflow-hidden">
                        <!-- Header with Gradient -->
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 text-white">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold mb-1">{{ $tryout->title }}</h3>
                                    <p class="text-green-100 text-sm">{{ $tryout->code }}</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white text-green-700">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Selesai
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-green-100 text-xs mb-1">Nilai</p>
                                    <p class="text-3xl font-bold">{{ $score }}</p>
                                </div>
                                <div>
                                    <p class="text-green-100 text-xs mb-1">Jumlah Soal</p>
                                    <p class="text-2xl font-bold">{{ $tryout->questions->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="p-6">
                            <!-- Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $userTryout ? \Carbon\Carbon::parse($userTryout->pivot->finished_at)->format('d M Y, H:i') : '-' }}</span>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Durasi: {{ $tryout->duration_minutes }} menit</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('tryout.review', $tryout->id) }}" 
                               class="block w-full text-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                Lihat Review
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function switchTab(tab) {
    const tabBelum = document.getElementById('tab-belum');
    const tabSudah = document.getElementById('tab-sudah');
    const contentBelum = document.getElementById('content-belum');
    const contentSudah = document.getElementById('content-sudah');

    if (tab === 'belum') {
        // Activate "Belum Dikerjakan" tab
        tabBelum.classList.remove('text-gray-400', 'font-medium');
        tabBelum.classList.add('text-[#184E83]', 'font-semibold', 'border-b-4', 'border-[#FFBF00]');
        
        tabSudah.classList.remove('text-[#184E83]', 'font-semibold', 'border-b-4', 'border-[#FFBF00]');
        tabSudah.classList.add('text-gray-400', 'font-medium');

        // Show/hide content
        contentBelum.classList.remove('hidden');
        contentSudah.classList.add('hidden');
    } else {
        // Activate "Sudah Dikerjakan" tab
        tabSudah.classList.remove('text-gray-400', 'font-medium');
        tabSudah.classList.add('text-[#184E83]', 'font-semibold', 'border-b-4', 'border-[#FFBF00]');
        
        tabBelum.classList.remove('text-[#184E83]', 'font-semibold', 'border-b-4', 'border-[#FFBF00]');
        tabBelum.classList.add('text-gray-400', 'font-medium');

        // Show/hide content
        contentSudah.classList.remove('hidden');
        contentBelum.classList.add('hidden');
    }
}
</script>
@endpush
@endsection