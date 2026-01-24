

<?php $__env->startSection('title', 'Kelola Users'); ?>
<?php $__env->startSection('page-title', 'Kelola Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-8">

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
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

        <!-- Filter Status -->
        <div class="relative">
            <select name="status"
                    onchange="this.form.submit()"
                    class="h-12 px-5 pr-10
                           bg-white rounded-full shadow-sm
                           border border-gray-200
                           text-sm text-gray-600
                           focus:ring-2 focus:ring-[#DC2626]
                           focus:border-transparent
                           appearance-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Aktif</option>
                <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Nonaktif</option>
            </select>

            <!-- Dropdown icon -->
            <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <!-- Filter Kelas -->
        <div class="relative">
            <select name="class_id"
                    onchange="this.form.submit()"
                    class="h-12 px-5 pr-10
                           bg-white rounded-full shadow-sm
                           border border-gray-200
                           text-sm text-gray-600
                           focus:ring-2 focus:ring-[#DC2626]
                           focus:border-transparent
                           appearance-none cursor-pointer">
                <option value="">Semua Kelas</option>
                <?php $__currentLoopData = $classes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($class->id); ?>"
                        <?php echo e(request('class_id') == $class->id ? 'selected' : ''); ?>>
                        <?php echo e($class->full_name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <!-- Dropdown icon -->
            <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <!-- Add User Button -->
        <a href="<?php echo e(route('admin.users.create')); ?>"
           class="h-12 px-6
                  bg-[#DC2626] hover:bg-[#B91C1C]
                  text-white text-sm font-semibold
                  rounded-full shadow-sm
                  flex items-center gap-2 transition">
            <span class="text-lg leading-none">+</span>
            User
        </a>
        
    </form>

    <!-- Segmented Control (4 tabs) -->
    <div class="mb-6">
        <div class="flex bg-white rounded-xl shadow-sm overflow-hidden">

            <!-- Tab: Semua User -->
            <a href="<?php echo e(route('admin.users.index', request()->except('role'))); ?>"
               class="flex-1 py-4 px-6 text-center text-sm transition
               <?php echo e(!request()->has('role')
                    ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                    : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                Semua User
            </a>

            <!-- Tab: Student -->
            <a href="<?php echo e(route('admin.users.index', array_merge(request()->except('role'), ['role' => 'student']))); ?>"
               class="flex-1 py-4 px-6 text-center text-sm transition
               <?php echo e(request('role') === 'student'
                    ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                    : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                Student
            </a>

            <!-- Tab: Tentor -->
            <a href="<?php echo e(route('admin.users.index', array_merge(request()->except('role'), ['role' => 'tentor']))); ?>"
               class="flex-1 py-4 px-6 text-center text-sm transition
               <?php echo e(request('role') === 'tentor'
                    ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                    : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                Tentor
            </a>

            <!-- Tab: Admin -->
            <a href="<?php echo e(route('admin.users.index', array_merge(request()->except('role'), ['role' => 'admin']))); ?>"
               class="flex-1 py-4 px-6 text-center text-sm transition
               <?php echo e(request('role') === 'admin'
                    ? 'font-semibold text-[#DC2626] border-b-4 border-[#FFBF00]'
                    : 'font-medium text-gray-400 hover:text-gray-600'); ?>">
                Admin
            </a>

        </div>
    </div>

    <!-- Users Table -->
    <?php if($users->isEmpty()): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada User</h3>
            <p class="text-gray-600 mb-6">Mulai tambahkan user pertama Anda</p>
            <a href="<?php echo e(route('admin.users.create')); ?>" 
               class="inline-flex items-center px-6 py-3 bg-[#DC2626] hover:bg-red-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah User
            </a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <?php if($user->photo): ?>
                                            <img src="<?php echo e(asset('storage/' . $user->photo)); ?>" 
                                                 alt="<?php echo e($user->name); ?>" 
                                                 class="w-10 h-10 rounded-full object-cover mr-3">
                                        <?php else: ?>
                                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&size=40&background=random" 
                                                 alt="<?php echo e($user->name); ?>" 
                                                 class="w-10 h-10 rounded-full mr-3">
                                        <?php endif; ?>
                                        <span class="text-sm font-semibold text-gray-900"><?php echo e($user->name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600"><?php echo e($user->email); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        <?php echo e($user->role === 'student' ? 'bg-blue-100 text-blue-800' : 
                                           ($user->role === 'tentor' ? 'bg-purple-100 text-purple-800' : 'bg-red-100 text-red-800')); ?>">
                                        <?php echo e(ucfirst($user->role)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($user->class): ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            <?php echo e($user->class->full_name); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($user->is_active): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- View -->
                                        <div class="relative group">
                                            <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" 
                                               class="inline-flex items-center justify-center w-9 h-9 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                Lihat Detail
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                    <div class="border-4 border-transparent border-t-gray-900"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit -->
                                        <div class="relative group">
                                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" 
                                               class="inline-flex items-center justify-center w-9 h-9 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                Edit
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                    <div class="border-4 border-transparent border-t-gray-900"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Toggle Status -->
                                        <?php if($user->id !== auth()->id()): ?>
                                            <form action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" method="POST" class="relative group">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" 
                                                        class="inline-flex items-center justify-center w-9 h-9 <?php echo e($user->is_active ? 'bg-gray-500 hover:bg-gray-600' : 'bg-green-500 hover:bg-green-600'); ?> text-white rounded-lg transition">
                                                    <?php if($user->is_active): ?>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                </button>
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                    <?php echo e($user->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>

                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php endif; ?>

                                        <!-- Hapus -->
                                        <?php if($user->id !== auth()->id()): ?>
                                            <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="relative group">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus user ini?')"
                                                        class="inline-flex items-center justify-center w-9 h-9 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                    Hapus
                                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                        <div class="border-4 border-transparent border-t-gray-900"></div>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($users->hasPages()): ?>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <?php echo e($users->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\fayat\tryout-app\resources\views/admin/users/index.blade.php ENDPATH**/ ?>