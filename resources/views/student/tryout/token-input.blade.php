@extends('layouts.app')

@section('title', 'Input Token - Hakuna Matata Course')

@section('breadcrumb')
    @include('components.breadcrumb', [
        'backUrl' => route('tryout.index'),
        'previousPage' => 'Daftar Tryout',
        'currentPage' => 'Input Token'
    ])
@endsection

@section('content')
<div class="p-8">
    
    <!-- Tryout Info Card - Full Width -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-8 text-white shadow-lg mb-8">
        <div class="flex items-center mb-4">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{ $tryout->title }}</h2>
                <p class="text-blue-100">{{ $tryout->code }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-white/20">
            <div>
                <p class="text-blue-100 text-sm">Jumlah Soal</p>
                <p class="text-2xl font-bold">{{ $tryout->total_questions }}</p>
            </div>
            <div>
                <p class="text-blue-100 text-sm">Durasi</p>
                <p class="text-2xl font-bold">{{ $tryout->duration_minutes }} menit</p>
            </div>
            <div>
                <p class="text-blue-100 text-sm">Periode</p>
                <p class="text-sm font-semibold">{{ $tryout->start_date->format('d M') }} - {{ $tryout->end_date->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    @if($isCompleted)
        <!-- Already Completed - Full Width -->
        <div class="bg-green-50 border border-green-200 rounded-xl p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-green-900 mb-2">Tryout Sudah Selesai</h3>
            <p class="text-green-700 mb-6">Anda telah menyelesaikan tryout ini sebelumnya</p>
            <a href="{{ route('tryout.review', $tryout->id) }}" 
               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Lihat Review Jawaban
            </a>
        </div>
    @else
        <!-- Token Input Form - Centered in Full Width -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Masukkan Token Tryout</h3>
                    <p class="text-gray-600">Dapatkan token dari tentor untuk memulai tryout</p>
                </div>

                <form action="{{ route('tryout.start', $tryout->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="token" class="block text-sm font-semibold text-gray-700 mb-2">
                            Token Akses (6 Karakter)
                        </label>
                        <input type="text" 
                               id="token" 
                               name="token" 
                               maxlength="6"
                               class="w-full px-6 py-4 text-center text-2xl font-mono font-bold uppercase border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('token') border-red-500 @enderror"
                               placeholder="XXXXXX"
                               required
                               autofocus>
                        @error('token')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-semibold text-yellow-900 mb-1">Perhatian!</h4>
                                <ul class="text-sm text-yellow-800 space-y-1">
                                    <li>• Pastikan koneksi internet stabil</li>
                                    <li>• Timer akan dimulai setelah klik "Mulai Tryout"</li>
                                    <li>• Jawaban akan disimpan otomatis</li>
                                    <li>• Tryout akan auto-submit jika waktu habis</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t">
                        <a href="{{ route('tryout.index') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                            Mulai Tryout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>

@push('scripts')
<script>
    // Auto uppercase token input
    document.getElementById('token').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
</script>
@endpush
@endsection