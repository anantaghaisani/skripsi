

<?php $__env->startSection('title', 'Kelola Kelas'); ?>
<?php $__env->startSection('page-title', 'Kelola Kelas'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">
    <div class="max-w-7xl mx-auto">

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                <p class="text-sm font-medium text-red-800"><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?>

        <!-- Search Bar + Filter + Button -->
        <form method="GET" class="mb-6 flex items-center gap-4">
            
            <!-- Search Bar -->
            <div class="flex-1">
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>

                    <input type="text"
                           name="search"
                           value="<?php echo e(request('search')); ?>"
                           placeholder="Cari"
                           class="w-full h-12 pl-11 pr-4
                                  bg-white rounded-full shadow-sm
                                  border border-gray-200
                                  text-sm
                                  focus:ring-2 focus:ring-[#DC2626]
                                  focus:border-transparent">
                </div>
            </div>

            <!-- Add Class Button -->
            <a href="<?php echo e(route('admin.classes.create')); ?>"
               class="h-12 px-6
                      bg-[#DC2626] hover:bg-[#B91C1C]
                      text-white text-sm font-semibold
                      rounded-full shadow-sm
                      flex items-center gap-2 transition">
                <span class="text-lg leading-none">+</span>
                Kelas
            </a>
            
        </form>

        <!-- Segmented Control (3 tabs by Jenjang) -->
        <div class="mb-6">
            <div class="flex bg-white rounded-xl shadow-sm overflow-hidden">

                <!-- Tab: Semua -->
                <a href="<?php echo e(route('admin.classes.index', request()->except('grade_level'))); ?>"
                   class="flex-1 py-4 px-6 text-center text-sm transition
                   <?php echo e(!request()->has('grade_level')
                        ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                        : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                    Semua
                </a>

                <!-- Tab: SD -->
                <a href="<?php echo e(route('admin.classes.index', array_merge(request()->except('grade_level'), ['grade_level' => 'SD']))); ?>"
                   class="flex-1 py-4 px-6 text-center text-sm transition
                   <?php echo e(request('grade_level') === 'SD'
                        ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                        : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                    SD
                </a>

                <!-- Tab: SMP -->
                <a href="<?php echo e(route('admin.classes.index', array_merge(request()->except('grade_level'), ['grade_level' => 'SMP']))); ?>"
                   class="flex-1 py-4 px-6 text-center text-sm transition
                   <?php echo e(request('grade_level') === 'SMP'
                        ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                        : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                    SMP
                </a>

                <!-- Tab: SMA -->
                <a href="<?php echo e(route('admin.classes.index', array_merge(request()->except('grade_level'), ['grade_level' => 'SMA']))); ?>"
                   class="flex-1 py-4 px-6 text-center text-sm transition
                   <?php echo e(request('grade_level') === 'SMA'
                        ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                        : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                    SMA
                </a>

            </div>
        </div>

        <!-- Classes Grid -->
        <?php if($classes->isEmpty()): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Kelas</h3>
                <p class="text-gray-600 mb-6">Mulai tambahkan kelas pertama Anda</p>
                <a href="<?php echo e(route('admin.classes.create')); ?>" 
                   class="inline-flex items-center px-6 py-3 bg-[#DC2626] hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kelas
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    <?php echo e($class->grade_level === 'SD' ? 'bg-green-100 text-green-700' : 
                                       ($class->grade_level === 'SMP' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700')); ?>">
                                    <?php echo e($class->grade_level); ?>

                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($class->full_name); ?></h3>
                            
                            <div class="flex items-center text-sm text-gray-600 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span><?php echo e($class->students_count); ?> Siswa</span>
                            </div>

                            <!-- Action Buttons (same as users) -->
                            <div class="flex items-center justify-center space-x-2">
                                <!-- View -->
                                <div class="relative group">
                                    <a href="<?php echo e(route('admin.classes.show', $class->id)); ?>" 
                                       class="inline-flex items-center justify-center w-9 h-9 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10">
                                        Lihat Detail
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                            <div class="border-4 border-transparent border-t-gray-900"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit -->
                                <div class="relative group">
                                    <a href="<?php echo e(route('admin.classes.edit', $class->id)); ?>" 
                                       class="inline-flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10">
                                        Edit
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                            <div class="border-4 border-transparent border-t-gray-900"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hapus (only if no students) -->
                                <?php if($class->students_count === 0): ?>
                                    <form action="<?php echo e(route('admin.classes.destroy', $class->id)); ?>" method="POST" class="relative group">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus kelas ini?')"
                                                class="inline-flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none z-10">
                                            Hapus
                                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                <div class="border-4 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <?php if($classes->hasPages()): ?>
                <div class="mt-6">
                    <?php echo e($classes->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/admin/classes/index.blade.php ENDPATH**/ ?>