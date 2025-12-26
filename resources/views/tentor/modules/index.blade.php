@extends('tentor.layouts.app')

@section('title', 'Kelola Modul - Hakuna Matata Course')

@section('breadcrumb')
    @include('tentor.components.breadcrumb', [
        'backUrl' => route('tentor.dashboard'),
        'previousPage' => 'Dashboard',
        'currentPage' => 'Kelola Modul'
    ])
@endsection

@section('content')
<div class="p-8">
    <div class="max-w-7xl mx-auto">

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Header Actions -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Modul</h2>
                <p class="text-gray-600 mt-1">Kelola modul pembelajaran</p>
            </div>
            <a href="{{ route('tentor.modules.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Modul
            </a>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('tentor.modules.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Modul</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari judul atau deskripsi..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hm-blue focus:border-transparent">
                    </div>

                    <!-- Filter Class -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <select name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-hm-blue">
                            <option value="">Semua Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_active" value="" {{ request('is_active') === null ? 'checked' : '' }} class="text-hm-blue">
                            <span class="ml-2 text-sm text-gray-700">Semua</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_active" value="1" {{ request('is_active') == '1' ? 'checked' : '' }} class="text-hm-blue">
                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_active" value="0" {{ request('is_active') == '0' ? 'checked' : '' }} class="text-hm-blue">
                            <span class="ml-2 text-sm text-gray-700">Nonaktif</span>
                        </label>
                    </div>

                    <div class="flex space-x-3">
                        <a href="{{ route('tentor.modules.index') }}" 
                           class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Reset
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <form id="bulk-delete-form" method="POST" action="{{ route('tentor.modules.bulk-delete') }}">
            @csrf
            @method('DELETE')
            
            <div id="bulk-actions" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-blue-900">
                        <span id="selected-count">0</span> modul dipilih
                    </span>
                    <button type="submit" 
                            onclick="return confirm('Yakin ingin menghapus modul yang dipilih?')"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                        Hapus Terpilih
                    </button>
                </div>
            </div>

            <!-- Modules Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @if($modules->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Modul</h3>
                        <p class="text-gray-600 mb-4">Mulai tambahkan modul pembelajaran</p>
                        <a href="{{ route('tentor.modules.create') }}" 
                           class="inline-flex items-center px-6 py-3 bg-hm-blue hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Modul
                        </a>
                    </div>
                @else
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" id="select-all" class="rounded text-hm-blue">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Modul</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($modules as $module)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="module_ids[]" value="{{ $module->id }}" class="module-checkbox rounded text-hm-blue">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $module->title }}</p>
                                                <p class="text-sm text-gray-500">{{ $module->file_type }} • {{ number_format($module->file_size / 1024 / 1024, 2) }} MB</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($module->classes->take(2) as $class)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                                    {{ $class->full_name }}
                                                </span>
                                            @endforeach
                                            @if($module->classes->count() > 2)
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                                    +{{ $module->classes->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button onclick="toggleStatus({{ $module->id }})" 
                                                class="status-toggle-{{ $module->id }} inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $module->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $module->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('tentor.modules.show', $module->id) }}" 
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                               title="Lihat Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('tentor.modules.edit', $module->id) }}" 
                                               class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition"
                                               title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('tentor.modules.destroy', $module->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus modul ini?')"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                        title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $modules->links() }}
                    </div>
                @endif
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
// Select All Checkbox
document.getElementById('select-all')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.module-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateBulkActions();
});

// Individual Checkboxes
document.querySelectorAll('.module-checkbox').forEach(cb => {
    cb.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checked = document.querySelectorAll('.module-checkbox:checked');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    
    if (checked.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = checked.length;
    } else {
        bulkActions.classList.add('hidden');
    }
}

// Toggle Status
function toggleStatus(moduleId) {
    fetch(`/tentor/modules/${moduleId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.querySelector(`.status-toggle-${moduleId}`);
            if (data.is_active) {
                btn.className = `status-toggle-${moduleId} inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700`;
                btn.textContent = 'Aktif';
            } else {
                btn.className = `status-toggle-${moduleId} inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700`;
                btn.textContent = 'Nonaktif';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
@endsection