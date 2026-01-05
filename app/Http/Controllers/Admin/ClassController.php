<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = Classes::withCount('students');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('grade_level', 'like', '%' . $request->search . '%')
                  ->orWhere('class_number', 'like', '%' . $request->search . '%');
            });
        }

        // Grade Level Filter
        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        $classes = $query->paginate(12);

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grade_level' => 'required|in:SD,SMP,SMA',
            'class_number' => [
                'required',
                'string',
                'max:10',
                Rule::unique('classes')->where(function ($query) use ($request) {
                    return $query->where('grade_level', $request->grade_level);
                })
            ],
        ], [
            'class_number.unique' => 'Kelas :input sudah ada untuk jenjang ' . $request->grade_level . '.',
        ]);

        Classes::create($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function show($id)
    {
        $class = Classes::withCount('students')->findOrFail($id);
        
        // Get students in this class
        $students = User::where('role', 'student')
            ->where('class_id', $class->id)
            ->get();
        
        // Get available students (ONLY students without any class)
        $availableStudents = User::where('role', 'student')
            ->whereNull('class_id')
            ->orderBy('name')
            ->get();
        
        return view('admin.classes.show', compact('class', 'students', 'availableStudents'));
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = Classes::findOrFail($id);

        $validated = $request->validate([
            'grade_level' => 'required|in:SD,SMP,SMA',
            'class_number' => [
                'required',
                'string',
                'max:10',
                Rule::unique('classes')->where(function ($query) use ($request) {
                    return $query->where('grade_level', $request->grade_level);
                })->ignore($class->id)
            ],
        ], [
            'class_number.unique' => 'Kelas :input sudah ada untuk jenjang ' . $request->grade_level . '.',
        ]);

        $class->update($validated);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $class = Classes::withCount('students')->findOrFail($id);

        if ($class->students_count > 0) {
            return redirect()->route('admin.classes.index')
                ->with('error', 'Tidak dapat menghapus kelas yang masih memiliki siswa!');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }

    // Add student to class
    public function addStudent(Request $request, $classId)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id'
        ]);
        
        $student = User::findOrFail($request->student_id);
        
        // Make sure it's a student
        if ($student->role !== 'student') {
            return redirect()->back()->with('error', 'User bukan siswa!');
        }
        
        $student->update(['class_id' => $classId]);
        
        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke kelas!');
    }

    // Remove student from class
    public function removeStudent($classId, $studentId)
    {
        $student = User::findOrFail($studentId);
        
        if ($student->class_id != $classId) {
            return redirect()->back()->with('error', 'Siswa tidak ada di kelas ini!');
        }
        
        $student->update(['class_id' => null]);
        
        return redirect()->back()->with('success', 'Siswa berhasil dikeluarkan dari kelas!');
    }
}