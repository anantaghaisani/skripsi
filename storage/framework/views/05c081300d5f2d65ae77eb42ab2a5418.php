

<?php $__env->startSection('title', 'Edit Modul'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo $__env->make('components.admin-breadcrumb', [
        'backUrl' => route('admin.module.index'),
        'previousPage' => 'Kelola Modul',
        'currentPage' => 'Edit Modul'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Form Edit Modul</h2>

        <form action="<?php echo e(route('admin.module.update', $module->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Modul <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="<?php echo e(old('title', $module->title)); ?>"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"><?php echo e(old('description', $module->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Current File -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Saat Ini</label>
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-900"><?php echo e($module->title); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e(strtoupper($module->file_type)); ?> • <?php echo e(number_format($module->file_size / 1024 / 1024, 2)); ?> MB</p>
                        </div>
                    </div>
                </div>

                <!-- File Upload (Optional) -->
                <div class="md:col-span-2">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti File (Opsional)
                    </label>
                    <input type="file" 
                           id="file" 
                           name="file" 
                           accept=".pdf"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah file. PDF only (Max. 10MB)</p>
                    <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Thumbnail (Optional) -->
                <div class="md:col-span-2">
                    <?php if($module->thumbnail): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Saat Ini</label>
                            <img src="<?php echo e(asset('storage/' . $module->thumbnail)); ?>" 
                                 alt="<?php echo e($module->title); ?>" 
                                 class="w-48 h-32 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                    <?php endif; ?>
                    
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                        <?php echo e($module->thumbnail ? 'Ganti Thumbnail (Opsional)' : 'Thumbnail (Opsional)'); ?>

                    </label>
                    <input type="file" 
                           id="thumbnail" 
                           name="thumbnail" 
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1"><?php echo e($module->thumbnail ? 'Kosongkan jika tidak ingin mengubah thumbnail. ' : ''); ?>JPG, PNG atau JPEG (Max. 2MB)</p>
                    <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Classes (Multiple Select) -->
                <div class="md:col-span-2">
                    <label for="class_ids" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas yang Dapat Mengakses <span class="text-red-600">*</span>
                    </label>
                    <div class="border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto">
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center py-2 hover:bg-gray-50 px-2 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="class_ids[]" 
                                       value="<?php echo e($class->id); ?>"
                                       <?php echo e(in_array($class->id, old('class_ids', $module->classes->pluck('id')->toArray())) ? 'checked' : ''); ?>

                                       class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <span class="ml-3 text-sm text-gray-900"><?php echo e($class->full_name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Pilih satu atau lebih kelas</p>
                    <?php $__errorArgs = ['class_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               <?php echo e(old('is_active', $module->is_active) ? 'checked' : ''); ?>

                               class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="ml-3 text-sm font-medium text-gray-900">Aktifkan modul ini</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-8">Modul aktif akan dapat diakses oleh siswa</p>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-4 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Modul
                    </button>
                    <a href="<?php echo e(route('admin.module.index')); ?>" 
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/admin/module/edit.blade.php ENDPATH**/ ?>