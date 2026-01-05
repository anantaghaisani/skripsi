@extends('tentor.layouts.app')

@section('title', 'Profile - Hakuna Matata Course')
@section('page-title', 'Profile')

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">

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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=184E83&color=fff" 
                                     alt="{{ $user->name }}"
                                     id="profile-photo-display" 
                                     class="w-32 h-32 rounded-full border-4 border-white shadow-md">
                            @endif
                            
                            <!-- Edit Photo Button -->
                            <label for="photo-input" class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer transition shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </label>
                        </div>

                        <!-- Hidden Photo Upload Form -->
                        <form id="photo-upload-form" action="{{ route('tentor.profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="hidden">
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

                        <div class="inline-flex items-center px-4 py-2 bg-purple-50 rounded-lg">
                            <svg class="w-4 h-4 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-purple-700">Tentor</span>
                        </div>

                        <!-- Delete Photo Button -->
                        @if($user->photo)
                            <form action="{{ route('tentor.profile.delete-photo') }}" method="POST" class="mt-4" onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-gray-500 hover:text-red-600 transition">
                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Info dapat diubah oleh admin
                                </button>
                            </form>
                        @else
                            <p class="text-xs text-gray-400 mt-4">
                                <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Info dapat diubah oleh admin
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                        <span class="mr-2">📊</span> Statistik Kamu
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600">Tryout Dibuat</span>
                            <span class="text-lg font-bold text-blue-600">{{ $createdTryouts }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600">Modul Dibuat</span>
                            <span class="text-lg font-bold text-purple-600">{{ $createdModules }}</span>
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
                    
                    <form action="{{ route('tentor.profile.update-password') }}" method="POST">
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
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-900 mb-1">Informasi</p>
                            <p class="text-sm text-blue-800">
                                Data seperti nama, email, dan role hanya dapat diubah oleh admin. Jika ada perubahan yang diperlukan, silakan hubungi admin sistem.
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
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-photo-display').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        
        // Auto submit form
        document.getElementById('photo-upload-form').submit();
    }
}
</script>
@endpush
@endsection