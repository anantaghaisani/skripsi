@extends('admin.layouts.app')

@section('title', 'Profile Admin')
@section('page-title', 'Profile')

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Profile Card & Stats -->
            <div class="space-y-6">
                
                <!-- Profile Card with Edit Photo -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center relative">
                        <!-- Profile Photo with Edit Button -->
                        <div class="relative inline-block mb-4">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" 
                                     alt="{{ $user->name }}" 
                                     id="profile-photo-display"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=DC2626&color=fff" 
                                     alt="{{ $user->name }}"
                                     id="profile-photo-display" 
                                     class="w-32 h-32 rounded-full border-4 border-white shadow-md">
                            @endif
                            
                            <!-- Edit Photo Button -->
                            <label for="photo-input" class="absolute bottom-0 right-0 bg-red-600 hover:bg-red-700 text-white rounded-full p-2 cursor-pointer transition shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </label>
                        </div>

                        <!-- Hidden Photo Upload Form -->
                        <form id="photo-upload-form" action="{{ route('admin.profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="hidden">
                            @csrf
                            @method('PUT')
                            <input type="file" 
                                   id="photo-input" 
                                   name="photo" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewAndSubmit(this)">
                        </form>

                        <!-- User Info -->
                        <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>

                        <div class="inline-flex items-center px-4 py-2 bg-red-50 rounded-lg">
                            <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-red-700">Administrator</span>
                        </div>

                        <!-- Delete Photo Button -->
                        @if($user->photo)
                            <form action="{{ route('admin.profile.delete-photo') }}" method="POST" class="mt-4" onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-gray-500 hover:text-red-600 transition">
                                    Hapus Foto
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                        <span class="mr-2">📊</span> Statistik Sistem
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600">Total Users</span>
                            <span class="text-lg font-bold text-blue-600">{{ $totalUsers }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600">Total Tryout</span>
                            <span class="text-lg font-bold text-green-600">{{ $totalTryouts }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600">Total Modul</span>
                            <span class="text-lg font-bold text-purple-600">{{ $totalModules }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Forms -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Change Password Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="mr-2">🔒</span> Ganti Password
                    </h3>
                    
                    <form action="{{ route('admin.profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Saat Ini
                                </label>
                                <input type="password" 
                                       id="current_password" 
                                       name="current_password"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                       required>
                                @error('current_password')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Baru
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                       required>
                                @error('password')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
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
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                       required>
                            </div>

                            <button type="submit" 
                                    class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Informasi Box -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-red-900 mb-1">Informasi Administrator</p>
                            <p class="text-sm text-red-800">
                                Sebagai administrator, Anda memiliki akses penuh ke seluruh sistem. Jagalah keamanan akun Anda dengan menggunakan password yang kuat.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
function previewAndSubmit(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-photo-display').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('photo-upload-form').submit();
    }
}
</script>
@endpush
@endsection