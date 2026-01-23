

<?php $__env->startSection('title', 'Dashboard - Hakuna Matata Course'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8 space-y-6">
    
    <!-- Compact Hero Banner -->
    <div class="relative bg-gradient-to-r from-[#184E83] via-blue-600 to-indigo-700 rounded-xl overflow-hidden shadow-lg">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute top-0 right-0 w-1/3 h-full opacity-10">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                <path fill="#FFFFFF" d="M44.7,-76.4C58.8,-69.2,71.8,-59.1,79.6,-45.8C87.4,-32.6,90,-16.3,88.5,-0.9C87,14.6,81.4,29.2,73.1,42.8C64.8,56.4,53.8,69,40.4,76.8C27,84.6,11.2,87.6,-4.8,85.9C-20.8,84.2,-37,77.8,-51.4,69.3C-65.8,60.8,-78.4,50.2,-85.3,36.4C-92.2,22.6,-93.4,5.6,-89.8,-9.8C-86.2,-25.2,-77.8,-38.9,-67.3,-50.8C-56.8,-62.7,-44.2,-72.8,-30.1,-80.1C-16,-87.4,-0.4,-92,14.6,-89.6C29.6,-87.2,30.6,-83.6,44.7,-76.4Z" transform="translate(100 100)" />
            </svg>
        </div>
        
       <div class="relative px-6 py-6 flex items-center justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white mb-1">
                    Selamat Datang, <?php echo e(Auth::user()->name); ?>! 👋
                </h1>
                <p class="text-blue-100 text-sm">
                    <?php if(Auth::user()->grade_level && Auth::user()->class_number): ?>
                        <?php echo e(Auth::user()->grade_level); ?> Kelas <?php echo e(Auth::user()->class_number); ?> • 
                    <?php endif; ?>
                    Siap belajar hari ini?
                </p>
            </div>
            
            <!-- Decorative icon -->
            <div class="hidden lg:block">
                <svg class="w-24 h-24 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18.5c-3.25-.92-6-4.62-6-8.5V8.3l6-3.11v15.31z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tryout -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Tryout</p>
                    <h3 class="text-3xl font-bold text-gray-900"><?php echo e($totalTryouts); ?></h3>
                </div>
                <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Tersedia untuk kamu</p>
        </div>

        <!-- Completed Tryout -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Sudah Dikerjakan</p>
                    <h3 class="text-3xl font-bold text-green-600"><?php echo e($completedTryouts); ?></h3>
                </div>
                <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Tryout selesai</p>
        </div>

        <!-- Average Score -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Rata-rata Nilai</p>
                    <h3 class="text-3xl font-bold text-yellow-600"><?php echo e(number_format($averageScore ?? 0, 1)); ?></h3>
                </div>
                <div class="w-14 h-14 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Dari semua tryout</p>
        </div>

        <!-- Total Modules -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Modul Tersedia</p>
                    <h3 class="text-3xl font-bold text-purple-600"><?php echo e($totalModules); ?></h3>
                </div>
                <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Untuk kelasmu</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Tryout Terbaru & Selesai -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Tryout Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">🎯 Tryout Terbaru</h2>
                    <a href="<?php echo e(route('tryout.index')); ?>" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                <?php if($recentTryouts->isEmpty()): ?>
                    <p class="text-center text-gray-500 py-8">Belum ada tryout baru</p>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $recentTryouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tryout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isCompleted = in_array($tryout->id, $completedTryoutIds);
                            ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm"><?php echo e($tryout->title); ?></h4>
                                        <p class="text-xs text-gray-500"><?php echo e($tryout->questions->count()); ?> soal • <?php echo e($tryout->start_date->format('d M Y')); ?></p>
                                    </div>
                                </div>
                                <?php if($isCompleted): ?>
                                    <a href="<?php echo e(route('tryout.review', $tryout->id)); ?>" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">
                                        Review
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('tryout.show', $tryout->id)); ?>" class="px-4 py-2 bg-[#FFC107] hover:bg-yellow-500 text-gray-900 text-sm font-semibold rounded-lg transition">
                                        Kerjakan
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tryout Selesai Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Tryout Selesai</h3>
                    </div>
                    <?php if($completedTryoutsList->isNotEmpty()): ?>
                        <a href="<?php echo e(route('tryout.index')); ?>" class="text-sm text-hm-blue hover:underline">
                            Lihat Semua →
                        </a>
                    <?php endif; ?>
                </div>

                <?php if($completedTryoutsList->isEmpty()): ?>
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-500">Belum ada tryout yang selesai</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $completedTryoutsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tryout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-green-300 transition">
                                <div class="flex items-start space-x-3 flex-1">
                                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 truncate"><?php echo e($tryout->title); ?></h4>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <span><?php echo e($tryout->questions->count()); ?> soal</span>
                                            <span class="mx-2">•</span>
                                            <span><?php echo e(\Carbon\Carbon::parse($tryout->finished_at)->format('d M Y, H:i')); ?></span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-green-600"><?php echo e($tryout->user_score); ?></div>
                                        <div class="text-xs text-gray-500">Nilai</div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Right Column: Modul Terakhir Dibuka -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">📖 Terakhir Dibuka</h2>
                    <a href="<?php echo e(route('modules.index')); ?>" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                <?php if($recentModules->isEmpty()): ?>
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="text-sm text-gray-500 mb-2">Belum ada modul dibuka</p>
                        <a href="<?php echo e(route('modules.index')); ?>" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                            Jelajahi Modul →
                        </a>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $recentModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('modules.show', $module->id)); ?>" 
                               class="block p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg hover:shadow-md transition">
                                <div class="flex items-start space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm truncate"><?php echo e($module->title); ?></h4>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded"><?php echo e($module->subject); ?></span>
                                            <span class="text-xs text-gray-500"><?php echo e($module->created_at->diffForHumans()); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl shadow-sm border border-purple-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">🚀 Quick Actions</h3>
                <div class="space-y-2">
                    <a href="<?php echo e(route('tryout.index')); ?>" class="block w-full py-3 px-4 bg-white hover:bg-gray-50 text-gray-900 font-medium rounded-lg transition text-center shadow-sm">
                        Lihat Semua Tryout
                    </a>
                    <a href="<?php echo e(route('modules.index')); ?>" class="block w-full py-3 px-4 bg-white hover:bg-gray-50 text-gray-900 font-medium rounded-lg transition text-center shadow-sm">
                        Jelajahi Modul
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/dashboard/index.blade.php ENDPATH**/ ?>