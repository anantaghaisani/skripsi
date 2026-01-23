

<?php $__env->startSection('title', 'Hasil Tryout - Hakuna Matata Course'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.tryout.monitor', $tryout->id),
        'previousPage' => 'Monitor',
        'currentPage' => 'Detail Hasil'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8 space-y-6">

    <!-- Student Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16">
                    <?php if($student->photo): ?>
                        <img class="w-16 h-16 rounded-full object-cover" src="<?php echo e(asset('storage/' . $student->photo)); ?>" alt="">
                    <?php else: ?>
                        <img class="w-16 h-16 rounded-full" src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($student->name)); ?>&size=64&background=184E83&color=fff" alt="">
                    <?php endif; ?>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900"><?php echo e($student->name); ?></h2>
                    <p class="text-sm text-gray-500"><?php echo e($student->email); ?></p>
                    <?php if($student->class): ?>
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                            <?php echo e($student->class->grade_level); ?> <?php echo e($student->class->class_number); ?><?php echo e($student->class->name); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 mb-1">Nilai</p>
                <?php
                    $score = $student->pivot->score ?? 0;
                    $formattedScore = $score == floor($score) ? number_format($score, 0) : number_format($score, 1);
                ?>
                <p class="text-4xl font-bold text-green-600"><?php echo e($formattedScore); ?></p>
            </div>
        </div>
    </div>

    <!-- Tryout Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Tryout</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Judul Tryout</p>
                <p class="font-semibold text-gray-900"><?php echo e($tryout->title); ?></p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Waktu Mulai</p>
                <p class="font-semibold text-gray-900">
                    <?php if($student->pivot->started_at): ?>
                        <?php echo e(\Carbon\Carbon::parse($student->pivot->started_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm')); ?>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Waktu Selesai</p>
                <p class="font-semibold text-gray-900">
                    <?php if($student->pivot->finished_at): ?>
                        <?php echo e(\Carbon\Carbon::parse($student->pivot->finished_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm')); ?>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Durasi Pengerjaan</p>
                <p class="font-semibold text-gray-900">
                    <?php if($student->pivot->started_at && $student->pivot->finished_at): ?>
                        <?php
                            $duration = \Carbon\Carbon::parse($student->pivot->started_at)->diffInMinutes(\Carbon\Carbon::parse($student->pivot->finished_at));
                            $formattedDuration = $duration == floor($duration) ? number_format($duration, 0) : number_format($duration, 1);
                        ?>
                        <?php echo e($formattedDuration); ?> menit
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Score Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Rincian Nilai</h3>
        
        <?php
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
        ?>

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
                    <p class="text-4xl font-bold text-green-600"><?php echo e($correctAnswers); ?></p>
                    <?php if($totalQuestions > 0): ?>
                        <?php
                            $percentage = ($correctAnswers / $totalQuestions) * 100;
                            $formattedPercentage = $percentage == floor($percentage) ? number_format($percentage, 0) : number_format($percentage, 1);
                        ?>
                        <p class="text-sm text-green-600 font-semibold mb-1">
                            <?php echo e($formattedPercentage); ?>%
                        </p>
                    <?php endif; ?>
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
                    <p class="text-4xl font-bold text-red-600"><?php echo e($wrongAnswers); ?></p>
                    <?php if($totalQuestions > 0): ?>
                        <?php
                            $percentage = ($wrongAnswers / $totalQuestions) * 100;
                            $formattedPercentage = $percentage == floor($percentage) ? number_format($percentage, 0) : number_format($percentage, 1);
                        ?>
                        <p class="text-sm text-red-600 font-semibold mb-1">
                            <?php echo e($formattedPercentage); ?>%
                        </p>
                    <?php endif; ?>
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
                    <p class="text-4xl font-bold text-gray-600"><?php echo e($unanswered); ?></p>
                    <?php if($totalQuestions > 0): ?>
                        <?php
                            $percentage = ($unanswered / $totalQuestions) * 100;
                            $formattedPercentage = $percentage == floor($percentage) ? number_format($percentage, 0) : number_format($percentage, 1);
                        ?>
                        <p class="text-sm text-gray-600 font-semibold mb-1">
                            <?php echo e($formattedPercentage); ?>%
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Summary Bar -->
        <?php if($totalQuestions > 0): ?>
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-medium text-gray-700">Progress Pengerjaan</p>
                <p class="text-sm font-semibold text-gray-900"><?php echo e($correctAnswers + $wrongAnswers); ?> / <?php echo e($totalQuestions); ?> soal</p>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                <div class="h-full flex">
                    <?php if($correctAnswers > 0): ?>
                        <div class="bg-green-600" style="width: <?php echo e(($correctAnswers / $totalQuestions) * 100); ?>%"></div>
                    <?php endif; ?>
                    <?php if($wrongAnswers > 0): ?>
                        <div class="bg-red-600" style="width: <?php echo e(($wrongAnswers / $totalQuestions) * 100); ?>%"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('tentor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/tentor/tryout/result.blade.php ENDPATH**/ ?>