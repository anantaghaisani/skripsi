@extends('admin.layouts.app')

@section('title', 'Edit Kelas')

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.classes.index'),
        'previousPage' => 'Kelola Kelas',
        'currentPage' => 'Edit Kelas'
    ])
@endsection

@section('content')
<div class="p-8">

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Edit Kelas: {{ $class->full_name }}</h2>

        <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Grade Level -->
            <div class="mb-4">
                <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenjang <span class="text-red-600">*</span>
                </label>
                <select id="grade_level" 
                        name="grade_level" 
                        required
                        onchange="updateClassNumbers()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Pilih Jenjang</option>
                    <option value="SD" {{ old('grade_level', $class->grade_level) === 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ old('grade_level', $class->grade_level) === 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ old('grade_level', $class->grade_level) === 'SMA' ? 'selected' : '' }}>SMA</option>
                </select>
                @error('grade_level')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class Number -->
            <div class="mb-4">
                <label for="class_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Tingkat Kelas <span class="text-red-600">*</span>
                </label>
                <select id="class_number" 
                        name="class_number" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <option value="">Pilih tingkat kelas</option>
                </select>
                @error('class_number')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Tingkat kelas sesuai jenjang yang dipilih</p>
            </div>

            <!-- Class Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kelas <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $class->name) }}"
                       placeholder="Contoh: A, B, IPA 1"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Masukkan nama kelas (misal: A, B, IPA 1, IPS 2)</p>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t">
                <a href="{{ route('admin.classes.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
function updateClassNumbers() {
    const gradeLevel = document.getElementById('grade_level').value;
    const classNumberSelect = document.getElementById('class_number');
    const currentClassNumber = '{{ old("class_number", $class->class_number) }}';
    
    // Clear existing options
    classNumberSelect.innerHTML = '<option value="">Pilih tingkat kelas</option>';
    
    let start, end;
    
    // Determine range based on grade level
    if (gradeLevel === 'SD') {
        start = 1;
        end = 6;
    } else if (gradeLevel === 'SMP') {
        start = 7;
        end = 9;
    } else if (gradeLevel === 'SMA') {
        start = 10;
        end = 12;
    } else {
        return; // No grade level selected
    }
    
    // Add options
    for (let i = start; i <= end; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = i;
        
        // Select current value
        if (currentClassNumber == i) {
            option.selected = true;
        }
        
        classNumberSelect.appendChild(option);
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', function() {
    updateClassNumbers();
});
</script>
@endpush
@endsection