@extends('layouts.app')

@section('title', 'Tryout - Hakuna Matata Course')
@section('page-title', 'Tryout')

@section('content')
<div class="p-8">
    <!-- Tabs -->
    <div class="mb-6">
        <div class="flex bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Active Tab: Belum Dikerjakan -->
            <button 
                id="tab-belum"
                onclick="switchTab('belum')"
                class="w-1/2 py-4 px-6 text-left text-sm font-semibold text-[#184E83] border-b-4 border-[#FFBF00] transition">
                Belum Dikerjakan
            </button>

            <!-- Inactive Tab: Sudah Dikerjakan -->
            <button 
                id="tab-sudah"
                onclick="switchTab('sudah')"
                class="w-1/2 py-4 px-6 text-left text-sm font-medium text-gray-400 hover:text-gray-600 transition">
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

    <!-- Tryout List - Belum Dikerjakan -->
    <div id="content-belum" class="space-y-4">
        @php
            $belumDikerjakan = $tryouts->filter(function($tryout) {
                $userTryout = $tryout->users->first();
                $status = $userTryout ? $userTryout->pivot->status : 'belum_dikerjakan';
                return $status !== 'sudah_dikerjakan';
            });
        @endphp

        @forelse($belumDikerjakan as $tryout)
            @php
                $userTryout = $tryout->users->first();
                $status = $userTryout ? $userTryout->pivot->status : 'belum_dikerjakan';
            @endphp

            <!-- Tryout Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-medium text-[#184E83] mb-2">{{ $tryout->code }}</h3>
                        <div class="flex items-start space-x-4">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Info -->
                            <div>
                                <h4 class="text-base font-bold text-gray-900 mb-2">{{ $tryout->title }}</h4>
                                <div class="flex items-center text-sm text-gray-600 space-x-2">
                                    <span>{{ $tryout->start_date->format('d F Y') }} - {{ $tryout->end_date->format('d F Y') }}</span>
                                    <span class="text-gray-400">•</span>
                                    <span>{{ $tryout->total_questions }} soal</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="flex-shrink-0">
                        @if($status == 'sedang_dikerjakan')
                            <a href="{{ route('tryout.work', $tryout->id) }}" 
                               class="inline-flex items-center px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition shadow-sm">
                                Lanjutkan
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        @else
                            <form action="{{ route('tryout.start', $tryout->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-2.5 bg-[#FFC107] hover:bg-yellow-500 text-gray-900 font-semibold rounded-lg transition shadow-sm">
                                    Kerjakan
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Tryout</h3>
                <p class="text-sm text-gray-500">Tryout yang belum dikerjakan akan muncul di sini.</p>
            </div>
        @endforelse
    </div>

    <!-- Tryout List - Sudah Dikerjakan (Hidden by default) -->
    <div id="content-sudah" class="space-y-4 hidden">
        @php
            $sudahDikerjakan = $tryouts->filter(function($tryout) {
                $userTryout = $tryout->users->first();
                return $userTryout && $userTryout->pivot->status === 'sudah_dikerjakan';
            });
        @endphp

        @forelse($sudahDikerjakan as $tryout)
            @php
                $userTryout = $tryout->users->first();
                $score = $userTryout->pivot->score ?? 0;
            @endphp

            <!-- Tryout Card - Completed -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-medium text-[#184E83] mb-2">{{ $tryout->code }}</h3>
                        <div class="flex items-start space-x-4">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Info -->
                            <div>
                                <h4 class="text-base font-bold text-gray-900 mb-2">{{ $tryout->title }}</h4>
                                <div class="flex items-center text-sm text-gray-600 space-x-2 mb-2">
                                    <span>{{ $tryout->start_date->format('d F Y') }} - {{ $tryout->end_date->format('d F Y') }}</span>
                                    <span class="text-gray-400">•</span>
                                    <span>{{ $tryout->total_questions }} soal</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">
                                        Nilai: {{ $score }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        Dikerjakan: {{ $userTryout->pivot->finished_at ? \Carbon\Carbon::parse($userTryout->pivot->finished_at)->format('d M Y, H:i') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-green-100 text-green-700">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Selesai
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Tryout yang Selesai</h3>
                <p class="text-sm text-gray-500">Tryout yang sudah kamu kerjakan akan muncul di sini.</p>
            </div>
        @endforelse
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
        tabBelum.classList.remove('text-gray-400');
        tabBelum.classList.add('text-[#184E83]', 'font-semibold', 'border-b-4', 'border-[#FFBF00]');
        
        tabSudah.classList.remove('text-[#184E83]', 'font-semibold', 'border-b-4', 'border-[#FFBF00]');
        tabSudah.classList.add('text-gray-400', 'font-medium');

        // Show/hide content
        contentBelum.classList.remove('hidden');
        contentSudah.classList.add('hidden');
    } else {
        // Activate "Sudah Dikerjakan" tab
        tabSudah.classList.remove('text-gray-400');
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