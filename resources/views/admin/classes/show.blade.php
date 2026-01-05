@extends('admin.layouts.app')

@section('title', 'Detail Kelas - ' . $class->full_name)

@section('breadcrumb')
    @include('components.admin-breadcrumb', [
        'backUrl' => route('admin.classes.index'),
        'previousPage' => 'Kelola Kelas',
        'currentPage' => $class->full_name
    ])
@endsection

@section('content')
<div class="p-8">

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Class Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $class->full_name }}</h2>
                        
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full mb-4
                            {{ $class->grade_level === 'SD' ? 'bg-green-100 text-green-700' : 
                               ($class->grade_level === 'SMP' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">
                            {{ $class->grade_level }}
                        </span>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="text-center mb-2">
                                <p class="text-3xl font-bold text-gray-900">{{ $students->count() }}</p>
                                <p class="text-sm text-gray-600">Total Siswa</p>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-2">
                            <a href="{{ route('admin.classes.edit', $class->id) }}" 
                               class="flex-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg transition">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Members Management -->
            <div class="lg:col-span-2">
                <!-- Add Member Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">➕ Tambah Anggota</h3>
                    <form action="{{ route('admin.classes.add-student', $class->id) }}" method="POST" class="flex gap-4">
                        @csrf
                        <div class="flex-1">
                            <select name="student_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">Pilih Siswa...</option>
                                @foreach($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" 
                                class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                            Tambah
                        </button>
                    </form>
                </div>

                <!-- Members List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">👥 Daftar Anggota ({{ $students->count() }})</h3>
                    
                    @if($students->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="text-gray-600">Belum ada anggota di kelas ini</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($students as $student)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <div class="flex items-center space-x-3">
                                        @if($student->photo)
                                            <img src="{{ asset('storage/' . $student->photo) }}" 
                                                 alt="{{ $student->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=40&background=random" 
                                                 alt="{{ $student->name }}" 
                                                 class="w-10 h-10 rounded-full">
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $student->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('admin.classes.remove-student', [$class->id, $student->id]) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin mengeluarkan {{ $student->name }} dari kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-sm font-semibold transition">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

</div>
@endsection