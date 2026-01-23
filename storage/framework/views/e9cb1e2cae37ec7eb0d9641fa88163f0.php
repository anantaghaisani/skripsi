<!-- Breadcrumb Component for Student -->
<!-- Usage: Include this in <?php $__env->startSection('breadcrumb'); ?> -->

<div class="flex items-center space-x-3">
    <!-- Back Button with Blue Background -->
    <a href="<?php echo e($backUrl); ?>" 
       class="p-2.5 bg-hm-blue hover:bg-blue-700 rounded-lg transition shadow-sm">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </a>
    
    <!-- Breadcrumb Text -->
    <div class="flex items-center space-x-3">
        <a href="<?php echo e($backUrl); ?>" class="text-xl text-gray-500 hover:text-gray-700 transition">
            <?php echo e($previousPage); ?>

        </a>
        <span class="text-xl text-gray-400">/</span>
        <span class="text-3xl font-bold text-hm-blue">
            <?php echo e($currentPage); ?>

        </span>
    </div>
</div><?php /**PATH C:\Users\fayat\tryout-app\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>