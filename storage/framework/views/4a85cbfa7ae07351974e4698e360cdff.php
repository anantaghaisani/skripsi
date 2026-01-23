

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-xl p-6 text-white">
            <h1 class="text-2xl font-bold mb-2">Selamat Datang, <?php echo e(Auth::user()->name); ?>! 👋</h1>
            <p class="text-red-100">Dashboard overview sistem Hakuna Matata Course</p>
        </div>

        <!-- Main Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">Active</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e($stats['total_users']); ?></h3>
                <p class="text-sm text-gray-600">Total Users</p>
            </div>

            <!-- Total Classes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-school text-purple-600 text-xl"></i>
                    </div>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e($stats['total_classes']); ?></h3>
                <p class="text-sm text-gray-600">Total Kelas</p>
            </div>

            <!-- Total Tryouts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-green-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded"><?php echo e($stats['active_tryouts']); ?> Active</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e($stats['total_tryouts']); ?></h3>
                <p class="text-sm text-gray-600">Total Tryout</p>
            </div>

            <!-- Total Modules -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded"><?php echo e($stats['active_modules']); ?> Active</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1"><?php echo e($stats['total_modules']); ?></h3>
                <p class="text-sm text-gray-600">Total Modul</p>
            </div>
        </div>

        <!-- User Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Students</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_students']); ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tentors</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_tentors']); ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Admins</p>
                        <h3 class="text-2xl font-bold text-gray-900"><?php echo e($stats['total_admins']); ?></h3>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-shield text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Recent Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">👥 Recent Users</h3>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="text-sm text-blue-600 hover:text-blue-700">
                        Lihat Semua →
                    </a>
                </div>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex items-center space-x-3">
                                <?php if($user->photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" alt="<?php echo e($user->name); ?>" class="w-10 h-10 rounded-full object-cover">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&size=40&background=random" alt="<?php echo e($user->name); ?>" class="w-10 h-10 rounded-full">
                                <?php endif; ?>
                                <div>
                                    <p class="font-semibold text-gray-900"><?php echo e($user->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($user->email); ?></p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                <?php echo e($user->role === 'student' ? 'bg-blue-100 text-blue-700' : ($user->role === 'tentor' ? 'bg-purple-100 text-purple-700' : 'bg-red-100 text-red-700')); ?>">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada user</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Popular Tryouts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">🔥 Popular Tryouts</h3>
                    <a href="<?php echo e(route('admin.tryout.index')); ?>" class="text-sm text-blue-600 hover:text-blue-700">
                        Lihat Semua →
                    </a>
                </div>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $tryoutStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tryout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900"><?php echo e($tryout->title); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($tryout->total_participants); ?> participants</p>
                            </div>
                            <div class="text-right">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm"><?php echo e($tryout->total_participants); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 text-sm text-center py-4">Belum ada tryout</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Class Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">🏫 Distribusi Kelas</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php $__empty_1 = true; $__currentLoopData = $classStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 transition">
                        <p class="font-bold text-gray-900 text-lg"><?php echo e($class->full_name); ?></p>
                        <p class="text-sm text-gray-600 mt-1"><?php echo e($class->students_count); ?> siswa</p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="col-span-full text-gray-500 text-sm text-center py-4">Belum ada kelas</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>