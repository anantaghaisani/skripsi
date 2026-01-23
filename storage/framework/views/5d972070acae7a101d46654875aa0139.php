

<?php $__env->startSection('title', 'Profile - Hakuna Matata Course'); ?>
<?php $__env->startSection('page-title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8 space-y-6">

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Profile Card & Stats -->
        <div class="space-y-6">
            
            <!-- Profile Card with Photo Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <!-- Profile Photo with Upload Button -->
                    <form id="photoUploadForm" action="<?php echo e(route('profile.update-photo')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="relative inline-block mb-4">
                            <!-- Photo -->
                            <?php if($user->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" 
                                     alt="<?php echo e($user->name); ?>" 
                                     class="w-32 h-32 rounded-full object-cover border-4 border-gray-100">
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&size=128&background=184E83&color=fff" 
                                     alt="<?php echo e($user->name); ?>" 
                                     class="w-32 h-32 rounded-full border-4 border-gray-100">
                            <?php endif; ?>
                            
                            <!-- Upload Button (Pencil Icon) -->
                            <label for="photoInput" class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 p-3 rounded-full cursor-pointer shadow-lg transition group">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                <input type="file" 
                                       id="photoInput" 
                                       name="photo" 
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="hidden"
                                       onchange="document.getElementById('photoUploadForm').submit()">
                            </label>
                        </div>
                    </form>

                    <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mb-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <!-- Delete Photo Button (if exists) -->
                    <?php if($user->photo): ?>
                        <form action="<?php echo e(route('profile.delete-photo')); ?>" method="POST" class="mb-4">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="text-xs text-red-600 hover:text-red-700 font-medium"
                                    onclick="return confirm('Yakin ingin menghapus foto?')">
                                Hapus Foto
                            </button>
                        </form>
                    <?php endif; ?>

                    <!-- User Info (Read-only) -->
                    <h2 class="text-xl font-bold text-gray-900 mb-1"><?php echo e($user->name); ?></h2>
                    <p class="text-sm text-gray-500 mb-4"><?php echo e($user->email); ?></p>

                    <!-- FIXED: Use class relationship -->
                    <?php if($user->class): ?>
                        <div class="inline-flex items-center px-4 py-2 bg-blue-50 rounded-lg">
                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm font-semibold text-blue-700">
                                <?php echo e($user->class->full_name); ?>

                            </span>
                        </div>
                    <?php else: ?>
                        <p class="text-xs text-gray-400 italic">Belum diatur oleh admin</p>
                    <?php endif; ?>

                    <p class="text-xs text-gray-400 mt-4">
                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Info dapat diubah oleh admin
                    </p>
                </div>
            </div>

            <!-- Mini Stats -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-4">📊 Statistik Kamu</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Tryout Selesai</span>
                        <span class="text-lg font-bold text-blue-600"><?php echo e($completedTryouts); ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Rata-rata Nilai</span>
                        <span class="text-lg font-bold text-yellow-600"><?php echo e(number_format($averageScore ?? 0, 1)); ?></span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Change Password Only -->
        <div class="lg:col-span-2">

            <!-- Update Password -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">🔒 Ganti Password</h3>
                
                <form action="<?php echo e(route('profile.update-password')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Saat Ini
                            </label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                            <?php $__errorArgs = ['current_password'];
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

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <button type="submit" 
                                class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900 mb-1">Informasi</h4>
                        <p class="text-sm text-blue-700">
                            Data seperti nama, email, dan kelas hanya dapat diubah oleh admin. 
                            Jika ada perubahan data, silakan hubungi admin.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/profile/index.blade.php ENDPATH**/ ?>