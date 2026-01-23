

<?php $__env->startSection('title', 'Modul Pembelajaran'); ?>
<?php $__env->startSection('page-title', 'Modul Pembelajaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white">
                <h1 class="text-3xl font-bold mb-2">📚 Modul Pembelajaran</h1>
                <p class="text-purple-100">Akses semua materi pembelajaran untuk kelasmu</p>
            </div>
        </div>

        <?php if($modules->isEmpty()): ?>
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Modul</h3>
                <p class="text-gray-600">Modul pembelajaran belum tersedia untuk kelasmu</p>
            </div>
        <?php else: ?>
            <!-- Modules Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition group">
                        <!-- Thumbnail -->
                        <?php if($module->thumbnail): ?>
                            <img src="<?php echo e(asset('storage/' . $module->thumbnail)); ?>" 
                                 alt="<?php echo e($module->title); ?>"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2"><?php echo e($module->title); ?></h3>
                            
                            <?php if($module->description): ?>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($module->description); ?></p>
                            <?php endif; ?>

                            <!-- Meta Info -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <?php echo e($module->creator->name); ?>

                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <?php echo e($module->created_at->diffForHumans()); ?>

                                </div>
                            </div>

                            <!-- File Info -->
                            <div class="flex items-center justify-between py-3 px-3 bg-gray-50 rounded-lg mb-4">
                                <span class="text-xs font-semibold text-gray-700 uppercase"><?php echo e($module->file_type); ?></span>
                                <span class="text-xs text-gray-500"><?php echo e(number_format($module->file_size / 1024 / 1024, 2)); ?> MB</span>
                            </div>

                            <!-- Action Button -->
                            <a href="<?php echo e(route('modules.show', $module->id)); ?>" 
                               class="block w-full text-center px-4 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-lg transition shadow-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($modules->links()); ?>

            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/modules/index.blade.php ENDPATH**/ ?>