@extends('layouts.app')

@section('title', 'Mengerjakan Tryout')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $tryout->title }}</h1>
                    <p class="text-sm text-gray-600 mt-1">{{ $tryout->code }}</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Waktu Tersisa</div>
                    <div id="timer" class="text-2xl font-bold text-red-600">02:00:00</div>
                </div>
            </div>

            <!-- Soal (Contoh) -->
            <div class="mb-8">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Soal 1</h3>
                    <p class="text-gray-700">Ini adalah contoh soal tryout. Dalam implementasi nyata, soal akan diambil dari database.</p>
                </div>

                <!-- Pilihan Jawaban -->
                <div class="space-y-3">
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                        <input type="radio" name="answer_1" value="A" class="mr-3">
                        <span>A. Pilihan A</span>
                    </label>
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                        <input type="radio" name="answer_1" value="B" class="mr-3">
                        <span>B. Pilihan B</span>
                    </label>
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                        <input type="radio" name="answer_1" value="C" class="mr-3">
                        <span>C. Pilihan C</span>
                    </label>
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                        <input type="radio" name="answer_1" value="D" class="mr-3">
                        <span>D. Pilihan D</span>
                    </label>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex items-center justify-between pt-6 border-t">
                <button class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Sebelumnya
                </button>
                <div class="flex space-x-2">
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Selanjutnya
                    </button>
                    <form action="{{ route('tryout.submit', $tryout->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengumpulkan jawaban?')">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Selesai & Kumpulkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Timer countdown
    let duration = {{ $tryout->duration_minutes }} * 60; // dalam detik
    const timerElement = document.getElementById('timer');

    function updateTimer() {
        const hours = Math.floor(duration / 3600);
        const minutes = Math.floor((duration % 3600) / 60);
        const seconds = duration % 60;

        timerElement.textContent = 
            String(hours).padStart(2, '0') + ':' + 
            String(minutes).padStart(2, '0') + ':' + 
            String(seconds).padStart(2, '0');

        if (duration <= 0) {
            alert('Waktu habis! Jawaban akan dikumpulkan otomatis.');
            document.querySelector('form').submit();
        }

        duration--;
    }

    // Update setiap detik
    setInterval(updateTimer, 1000);
    updateTimer();
</script>
@endpush
@endsection
