@extends('admin.layouts.app')

@section('title', 'Hasil Tryout - Hakuna Matata Course')

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.tryout.monitor', $tryout->id),
        'previousPage' => 'Monitor',
        'currentPage' => 'Detail Hasil'
    ])
@endsection

@section('content')
<div class="p-8 space-y-6">

    <!-- Student Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16">
                    @if($student->photo)
                        <img class="w-16 h-16 rounded-full object-cover" src="{{ asset('storage/' . $student->photo) }}" alt="">
                    @else
                        <img class="w-16 h-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=64&background=DC2626&color=fff" alt="">
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

    <!-- Score Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Rincian Nilai</h3>
        
        @php
            $totalQuestions = $tryout->total_questions ?? 0;
            $score = $student->pivot->score ?? 0;
            
            // Calculate correct answers from score (assuming each question worth equal points)
            // If score is 100 and total questions is 25, then correct = 25
            $correctAnswers = $totalQuestions > 0 ? round(($score / 100) * $totalQuestions) : 0;
            
            // Get answers data from pivot if available, otherwise calculate
            if (isset($student->pivot->correct_answers)) {
                $correctAnswers = $student->pivot->correct_answers;
            }
            
            if (isset($student->pivot->wrong_answers)) {
                $wrongAnswers = $student->pivot->wrong_answers;
            } else {
                // Calculate wrong answers
                $wrongAnswers = $totalQuestions - $correctAnswers;
            }
            
            // Unanswered = total - (correct + wrong)
            // If all answered, unanswered should be 0
            $answered = $correctAnswers + $wrongAnswers;
            $unanswered = $totalQuestions > $answered ? $totalQuestions - $answered : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Benar -->
            <div class="bg-green-50 rounded-xl p-6 border-2 border-green-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-green-700 mb-2">Jawaban Benar</p>
                <div class="flex items-end justify-between">
                    <p class="text-4xl font-bold text-green-600">{{ $correctAnswers }}</p>
                    @if($totalQuestions > 0)
                        <p class="text-sm text-green-600 font-semibold mb-1">
                            {{ number_format(($correctAnswers / $totalQuestions) * 100, 1) }}%
                        </p>
                    @endif
                </div>
            </div>

            <!-- Salah -->
            <div class="bg-red-50 rounded-xl p-6 border-2 border-red-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-red-700 mb-2">Jawaban Salah</p>
                <div class="flex items-end justify-between">
                    <p class="text-4xl font-bold text-red-600">{{ $wrongAnswers }}</p>
                    @if($totalQuestions > 0)
                        <p class="text-sm text-red-600 font-semibold mb-1">
                            {{ number_format(($wrongAnswers / $totalQuestions) * 100, 1) }}%
                        </p>
                    @endif
                </div>
            </div>

            <!-- Tidak Dijawab -->
            <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-gray-700 mb-2">Tidak Dijawab</p>
                <div class="flex items-end justify-between">
                    <p class="text-4xl font-bold text-gray-600">{{ $unanswered }}</p>
                    @if($totalQuestions > 0)
                        <p class="text-sm text-gray-600 font-semibold mb-1">
                            {{ number_format(($unanswered / $totalQuestions) * 100, 1) }}%
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Summary Bar -->
        @if($totalQuestions > 0)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-gray-700">Progress Pengerjaan</p>
                <p class="text-sm font-semibold text-gray-900">{{ $correctAnswers + $wrongAnswers }} / {{ $totalQuestions }} soal</p>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="h-full flex">
                    @if($correctAnswers > 0)
                        <div class="bg-green-600" style="width: {{ ($correctAnswers / $totalQuestions) * 100 }}%"></div>
                    @endif
                    @if($wrongAnswers > 0)
                        <div class="bg-red-600" style="width: {{ ($wrongAnswers / $totalQuestions) * 100 }}%"></div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection