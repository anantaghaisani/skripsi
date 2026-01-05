@extends('admin.layouts.app')

@section('title', 'Kelola Tryout')
@section('page-title', 'Kelola Tryout')

@section('content')
<div class="p-8 space-y-6">

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Search Bar and Filters -->
    <div class="flex items-center gap-4">
        <!-- Search Bar -->
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" 
                   id="searchInput"
                   placeholder="Cari berdasarkan nama, creator, kelas, atau tanggal tryout..."
                   class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-full focus:ring-2 focus:ring-[#DC2626] focus:border-transparent"
                   onkeyup="searchTryouts()">
        </div>

        <!-- Filter Creator -->
        <div class="relative">
            <form method="GET" id="filterForm">
                <select name="creator_id" 
                        onchange="document.getElementById('filterForm').submit()"
                        class="h-12 px-5 pr-10
                               bg-white rounded-full shadow-sm
                               border border-gray-200
                               text-sm text-gray-600
                               focus:ring-2 focus:ring-[#DC2626]
                               focus:border-transparent
                               appearance-none cursor-pointer">
                    <option value="">Semua Creator</option>
                    @foreach($creators as $creator)
                        <option value="{{ $creator->id }}" {{ request('creator_id') == $creator->id ? 'selected' : '' }}>
                            {{ $creator->name }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Dropdown icon -->
                <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </form>
        </div>

        <!-- Create Button -->
        <a href="{{ route('admin.tryout.create') }}" 
           class="h-12 px-6
                  bg-[#DC2626] hover:bg-red-700
                  text-white text-sm font-semibold
                  rounded-full shadow-sm
                  flex items-center gap-2 transition whitespace-nowrap">
            <span class="text-lg leading-none">+</span>
            Tryout
        </a>
    </div>

    <!-- Tryout List -->
    @if($tryouts->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Tryout</h3>
            <p class="text-gray-600 mb-6">Mulai tambahkan tryout</p>
            <a href="{{ route('admin.tryout.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-[#DC2626] hover:bg-red-700 text-white font-semibold rounded-lg transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Tryout
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tryout</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Token</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tryouts as $tryout)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ $tryout->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $tryout->code }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ $tryout->total_questions }} soal • {{ $tryout->duration_minutes }} menit</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($tryout->creator)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-semibold text-gray-600">{{ substr($tryout->creator->name, 0, 2) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $tryout->creator->name }}</div>
                                                <div class="text-xs text-gray-500">{{ ucfirst($tryout->creator->role) }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Creator dihapus</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-mono font-bold bg-red-100 text-red-800">
                                        {{ $tryout->token }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tryout->classes->take(2) as $class)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $class->grade_level }} {{ $class->class_number }}{{ $class->name }}
                                            </span>
                                        @endforeach
                                        @if($tryout->classes->count() > 2)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                +{{ $tryout->classes->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div>{{ $tryout->start_date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">s/d {{ $tryout->end_date->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($tryout->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Kelola Soal -->
                                        <div class="relative group">
                                            <a href="{{ route('admin.question.index', $tryout->id) }}" 
                                               class="inline-flex items-center justify-center w-9 h-9 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                Kelola Soal
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                    <div class="border-4 border-transparent border-t-gray-900"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Monitor -->
                                        <div class="relative group">
                                            <a href="{{ route('admin.tryout.monitor', $tryout->id) }}" 
                                               class="inline-flex items-center justify-center w-9 h-9 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                            </a>
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition pointer-events-none">
                                                Monitor
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                    <div class="border-4 border-transparent border-t-gray-900"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit -->
                                        <div class="relative group">
                                            <a href="{{ route('admin.tryout.edit', $tryout->id) }}" 
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

                                        <!-- Hapus -->
                                        <form action="{{ route('admin.tryout.destroy', $tryout->id) }}" method="POST" class="relative group">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus tryout ini?')"
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tryouts->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $tryouts->links() }}
                </div>
            @endif
        </div>
    @endif

</div>

@push('scripts')
<script>
function searchTryouts() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        // Get text content from relevant columns
        const titleCell = row.cells[0]?.textContent.toLowerCase() || '';
        const creatorCell = row.cells[1]?.textContent.toLowerCase() || '';
        const tokenCell = row.cells[2]?.textContent.toLowerCase() || '';
        const classCell = row.cells[3]?.textContent.toLowerCase() || '';
        const dateCell = row.cells[4]?.textContent.toLowerCase() || '';
        
        // Combine all searchable text
        const searchText = titleCell + ' ' + creatorCell + ' ' + tokenCell + ' ' + classCell + ' ' + dateCell;
        
        // Show/hide row based on match
        if (searchText.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Show "no results" message if all rows are hidden
    const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
    let noResultsRow = document.getElementById('noResultsRow');
    
    if (visibleRows.length === 0 && filter !== '') {
        if (!noResultsRow) {
            noResultsRow = document.createElement('tr');
            noResultsRow.id = 'noResultsRow';
            noResultsRow.innerHTML = `
                <td colspan="7" class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">Tidak ada tryout yang cocok dengan pencarian</p>
                    <p class="text-gray-400 text-sm mt-1">Coba kata kunci lain</p>
                </td>
            `;
            document.querySelector('tbody').appendChild(noResultsRow);
        }
        noResultsRow.style.display = '';
    } else if (noResultsRow) {
        noResultsRow.style.display = 'none';
    }
}
</script>
@endpush
@endsection