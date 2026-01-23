

<?php $__env->startSection('title', 'Detail Modul - Hakuna Matata Course'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'backUrl' => route('modules.index'),
        'previousPage' => 'Daftar Modul',
        'currentPage' => $module->title
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="max-w-7xl mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Module Preview -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Module Cover/Thumbnail -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <?php if($module->thumbnail): ?>
                        <img src="<?php echo e(asset('storage/' . $module->thumbnail)); ?>" 
                             alt="<?php echo e($module->title); ?>" 
                             class="w-full h-96 object-cover">
                    <?php else: ?>
                        <div class="w-full h-96 bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center">
                            <i class="fas fa-book text-white text-8xl"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Module Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <?php if($module->description): ?>
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2">Deskripsi</h3>
                            <p class="text-gray-600 leading-relaxed"><?php echo e($module->description); ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="flex gap-4">
                        <?php if($module->file_type === 'pdf'): ?>
                            <a href="<?php echo e(route('modules.view-pdf', $module->id)); ?>" 
                               target="_blank"
                               class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition text-center">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat PDF
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('modules.download-pdf', $module->id)); ?>" 
                           class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition text-center">
                            <i class="fas fa-download mr-2"></i>
                            Download
                        </a>
                    </div>
                </div>

            </div>

            <!-- Right: Module Info -->
            <div class="space-y-6">
                
                <!-- Informasi Modul -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Modul</h3>
                    
                    <div class="space-y-4">
                        <!-- Dibuat oleh -->
                        <div>
                            <div class="flex items-center text-sm text-gray-600 mb-1">
                                <i class="fas fa-user w-5 mr-2"></i>
                                <span>Dibuat oleh</span>
                            </div>
                            <p class="font-semibold text-gray-900 ml-7"><?php echo e($module->creator->name); ?></p>
                        </div>

                        <!-- Dibuat -->
                        <div>
                            <div class="flex items-center text-sm text-gray-600 mb-1">
                                <i class="fas fa-calendar w-5 mr-2"></i>
                                <span>Dibuat</span>
                            </div>
                            <p class="font-semibold text-gray-900 ml-7"><?php echo e($module->created_at->format('d M Y')); ?></p>
                        </div>

                        <!-- Terakhir diubah -->
                        <div>
                            <div class="flex items-center text-sm text-gray-600 mb-1">
                                <i class="fas fa-clock w-5 mr-2"></i>
                                <span>Terakhir diubah</span>
                            </div>
                            <p class="font-semibold text-gray-900 ml-7"><?php echo e($module->updated_at->format('d M Y')); ?></p>
                        </div>

                        <!-- File Info -->
                        <div>
                            <div class="flex items-center text-sm text-gray-600 mb-1">
                                <i class="fas fa-file w-5 mr-2"></i>
                                <span>Tipe File</span>
                            </div>
                            <p class="font-semibold text-gray-900 ml-7 uppercase"><?php echo e($module->file_type); ?></p>
                        </div>

                        <!-- File Size -->
                        <div>
                            <div class="flex items-center text-sm text-gray-600 mb-1">
                                <i class="fas fa-hdd w-5 mr-2"></i>
                                <span>Ukuran</span>
                            </div>
                            <p class="font-semibold text-gray-900 ml-7"><?php echo e(number_format($module->file_size / 1024 / 1024, 2)); ?> MB</p>
                        </div>
                    </div>
                </div>

                <!-- Kelas yang Dapat Mengakses -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Kelas yang Dapat Mengakses</h3>
                    
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $module->classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="px-3 py-2 bg-purple-100 text-purple-700 text-sm font-semibold rounded-lg flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                <?php echo e($class->full_name); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/modules/show.blade.php ENDPATH**/ ?>