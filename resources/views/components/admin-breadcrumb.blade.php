<!-- Breadcrumb Component for Admin -->
<!-- Usage: Include this in @section('breadcrumb') -->

<div class="flex items-center space-x-3">
    <!-- Back Button with Red Background -->
    <a href="{{ $backUrl }}" 
       class="p-2.5 bg-[#DC2626] hover:bg-red-700 rounded-lg transition shadow-sm">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </a>
    
    <!-- Breadcrumb Text -->
    <div class="flex items-center space-x-3">
        <a href="{{ $backUrl }}" class="text-xl text-gray-500 hover:text-gray-700 transition">
            {{ $previousPage }}
        </a>
        <span class="text-xl text-gray-400">/</span>
        <span class="text-3xl font-bold text-[#DC2626]">
            {{ $currentPage }}
        </span>
    </div>
</div>