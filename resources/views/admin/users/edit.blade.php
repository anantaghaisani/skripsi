@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.users.index'),
        'previousPage' => 'Kelola Users',
        'currentPage' => 'Edit User'
    ])
@endsection

@section('content')
<div class="p-8">

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Form Edit User</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Current Photo -->
                @if($user->photo)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                        <img src="{{ asset('storage/' . $user->photo) }}" 
                             alt="{{ $user->name }}" 
                             class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                    </div>
                @endif

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           required>
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-600">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           required>
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (Optional) -->
                <div class="md:col-span-2">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru (Opsional)
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter</p>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-600">*</span>
                    </label>
                    <select id="role" 
                            name="role"
                            onchange="toggleClassField()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            required>
                        <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Student</option>
                        <option value="tentor" {{ old('role', $user->role) === 'tentor' ? 'selected' : '' }}>Tentor</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class (only for students) -->
                <div id="class-field" style="display: {{ old('role', $user->role) === 'student' ? 'block' : 'none' }}">
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas
                    </label>
                    <select id="class_id" 
                            name="class_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $user->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti Foto Profil
                    </label>
                    <input type="file" 
                           id="photo" 
                           name="photo" 
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG atau JPEG (Max. 2MB)</p>
                    @error('photo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-4 pt-6 border-t">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
function toggleClassField() {
    const role = document.getElementById('role').value;
    const classField = document.getElementById('class-field');
    
    if (role === 'student') {
        classField.style.display = 'block';
    } else {
        classField.style.display = 'none';
        document.getElementById('class_id').value = '';
    }
}
</script>
@endpush
@endsection