@extends('tentor.layout')

@section('title', 'Hasil Tryout - Hakuna Matata Course')
@section('page-title', 'Hasil Tryout')

@section('content')
<div class="p-8 space-y-6">

    <!-- Back Button -->
    <div>
        <a href="{{ route('tentor.tryout.monitor', $tryout->id) }}" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Monitor
        </a>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16">
                    @if($student->photo)
                        <img class="w-16 h-16 rounded-full object-cover" src="{{ asset('storage/' . $student->photo) }}" alt="">
                    @else
                        <img class="w-16 h-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=64&background=184E83&color=fff" alt="">
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $student->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $student->email }}</p>
                    @if($student->class)
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                            {{ $student->class->grade_level }} {{ $student->class->class_number }}{{ $student->class->name }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 mb-1">Nilai</p>
                <p class="text-4xl font-bold text-green-600">{{ number_format($student->pivot->score, 1) }}</p>
            </div>
        </div>
    </div>

    <!-- Tryout Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Tryout</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Judul Tryout</p>
                <p class="font-semibold text-gray-900">{{ $tryout->title }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Waktu Mulai</p>
                <p class="font-semibold text-gray-900">
                    {{ $student->pivot->started_at ? \Carbon\Carbon::parse($student->pivot->started_at)->format('d M Y, H:i') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Waktu Selesai</p>
                <p class="font-semibold text-gray-900">
                    {{ $student->pivot->finished_at ? \Carbon\Carbon::parse($student->pivot->finished_at)->format('d M Y, H:i') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Durasi Pengerjaan</p>
                <p class="font-semibold text-gray-900">
                    @if($student->pivot->started_at && $student->pivot->finished_at)
                        {{ \Carbon\Carbon::parse($student->pivot->started_at)->diffInMinutes(\Carbon\Carbon::parse($student->pivot->finished_at)) }} menit
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Score Breakdown (Placeholder) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Rincian Nilai</h3>
        
        <!-- Info: Questions table not yet created -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 mx-auto text-blue-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h4 class="text-lg font-semibold text-blue-900 mb-2">Fitur Dalam Pengembangan</h4>
            <p class="text-sm text-blue-700 mb-4">
                Rincian jawaban per soal akan tersedia setelah tabel questions dan answers dibuat.
            </p>
            <div class="text-sm text-blue-600">
                <p class="mb-1"><strong>Yang akan ditampilkan:</strong></p>
                <ul class="text-left max-w-md mx-auto">
                    <li>✓ Jawaban siswa per soal</li>
                    <li>✓ Kunci jawaban yang benar</li>
                    <li>✓ Status (benar/salah)</li>
                    <li>✓ Pembahasan soal</li>
                </ul>
            </div>
        </div>

        <!-- Temporary Stats -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-green-50 rounded-lg p-4 text-center">
                <p class="text-sm text-green-700 mb-1">Benar</p>
                <p class="text-2xl font-bold text-green-600">-</p>
            </div>
            <div class="bg-red-50 rounded-lg p-4 text-center">
                <p class="text-sm text-red-700 mb-1">Salah</p>
                <p class="text-2xl font-bold text-red-600">-</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-700 mb-1">Tidak Dijawab</p>
                <p class="text-2xl font-bold text-gray-600">-</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div>
            <h3 class="font-semibold text-gray-900 mb-1">Aksi Tambahan</h3>
            <p class="text-sm text-gray-500">Export atau cetak hasil tryout siswa</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export PDF
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak
            </button>
        </div>
    </div>

</div>
@endsection