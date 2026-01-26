

<?php $__env->startSection('title', 'Detail User - ' . $user->name); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('components.admin-breadcrumb', [
        'backUrl' => route('admin.users.index'),
        'previousPage' => 'Kelola Users',
        'currentPage' => $user->name
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: User Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <!-- Photo -->
                        <?php if($user->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" 
                                 alt="<?php echo e($user->name); ?>" 
                                 class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-gray-200">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&size=96&background=random" 
                                 alt="<?php echo e($user->name); ?>" 
                                 class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-gray-200">
                        <?php endif; ?>
                        
                        <h2 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($user->name); ?></h2>
                        
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full mb-4
                            <?php echo e($user->role === 'student' ? 'bg-blue-100 text-blue-700' : 
                               ($user->role === 'tentor' ? 'bg-purple-100 text-purple-700' : 'bg-red-100 text-red-700')); ?>">
                            <?php echo e(ucfirst($user->role)); ?>

                        </span>

                        <div class="mt-6 pt-6 border-t border-gray-200 text-left space-y-3">
                            <!-- Email -->
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Email</p>
                                <p class="text-sm font-medium text-gray-900"><?php echo e($user->email); ?></p>
                            </div>

                            <!-- Class (for students) -->
                            <?php if($user->role === 'student'): ?>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Kelas</p>
                                    <?php if($user->class): ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            <?php echo e($user->class->full_name); ?>

                                        </span>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-400">Belum ditentukan</p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Member Since - FIXED -->
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Bergabung Sejak</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <?php if($user->created_at): ?>
                                        <?php echo e(\Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('D MMM YYYY')); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-2">
                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit User
                            </a>
                            <?php if($user->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" 
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus User
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Stats & Activity -->
            <div class="lg:col-span-2 space-y-6">
                
                <?php if($user->role === 'student'): ?>
                    <!-- Student Stats -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Statistik</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Total Tryouts -->
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Tryout</p>
                                        <p class="text-2xl font-bold text-blue-900 mt-1"><?php echo e($user->tryouts()->count()); ?></p>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Completed Tryouts -->
                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Selesai</p>
                                        <p class="text-2xl font-bold text-green-900 mt-1"><?php echo e($user->tryouts()->wherePivot('status', 'sudah_dikerjakan')->count()); ?></p>
                                    </div>
                                    <div class="w-12 h-12 bg-green-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Tryouts - FIXED -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📝 Tryout Terbaru</h3>
                        
                        <?php $__empty_1 = true; $__currentLoopData = $user->tryouts()->latest()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tryout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="flex items-center justify-between p-3 border-b last:border-b-0 hover:bg-gray-50 transition">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900"><?php echo e($tryout->title); ?></p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <?php if($tryout->pivot->finished_at): ?>
                                            <?php echo e(\Carbon\Carbon::parse($tryout->pivot->finished_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm')); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <?php if($tryout->pivot->status === 'sudah_dikerjakan'): ?>
                                        <?php
                                            $score = $tryout->pivot->score ?? 0;
                                            $formattedScore = $score == floor($score) ? number_format($score, 0) : number_format($score, 1);
                                        ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?php echo e($formattedScore); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Belum Selesai
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-center text-gray-500 py-6">Belum ada tryout</p>
                        <?php endif; ?>
                    </div>

                <?php elseif($user->role === 'tentor'): ?>
                    <!-- Tentor Stats -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📊 Konten yang Dibuat</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Total Tryouts Created -->
                            <div class="bg-purple-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Tryout</p>
                                        <p class="text-2xl font-bold text-purple-900 mt-1"><?php echo e($user->createdTryouts()->count()); ?></p>
                                    </div>
                                    <div class="w-12 h-12 bg-purple-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Modules Created -->
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Modul</p>
                                        <p class="text-2xl font-bold text-blue-900 mt-1"><?php echo e($user->createdModules()->count()); ?></p>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Admin Info -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">ℹ️ Info Administrator</h3>
                        <p class="text-gray-600">User ini memiliki akses penuh ke seluruh sistem sebagai administrator.</p>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/admin/users/show.blade.php ENDPATH**/ ?>