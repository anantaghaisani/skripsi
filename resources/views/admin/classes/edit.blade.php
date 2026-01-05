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
            <div class="mb-6">
                <label for="class_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Kelas <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       id="class_number" 
                       name="class_number" 
                       value="{{ old('class_number', $class->class_number) }}"
                       placeholder="Contoh: 7A, 10B, 12 IPA 1"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                @error('class_number')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Contoh: 7A untuk SMP 7A, 10B untuk SMA 10B</p>
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
@endsection