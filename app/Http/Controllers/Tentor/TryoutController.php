<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryoutController extends Controller
{
    /**
     * Display a listing of tryouts created by this tentor
     */
    public function index()
    {
        $tryouts = Tryout::byCreator(Auth::id())
            ->with('classes')
            ->latest()
            ->paginate(10);

        return view('tentor.tryout.index', compact('tryouts'));
    }

    /**
     * Show the form for creating a new tryout
     */
    public function create()
    {
        $classes = Classes::active()->orderBy('grade_level')->orderBy('class_number')->get();
        
        return view('tentor.tryout.create', compact('classes'));
    }

    /**
     * Store a newly created tryout
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tryouts,code',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_questions' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:1',
            'classes' => 'required|array|min:1',
            'classes.*' => 'exists:classes,id',
        ]);

        // Create tryout (token auto-generated)
        $tryout = Tryout::create([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_questions' => $validated['total_questions'],
            'duration_minutes' => $validated['duration_minutes'],
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        // Attach classes
        $tryout->classes()->attach($validated['classes']);

        // REDIRECT KE BULK ADD SOAL (UPDATED!)
        return redirect()->route('tentor.question.bulk-create', $tryout->id)
            ->with('success', 'Tryout berhasil dibuat dengan token: ' . $tryout->token . '. Silakan tambahkan soal sekarang.');
    }

    /**
     * Show the form for editing the specified tryout
     */
    public function edit($id)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($id);
        $classes = Classes::active()->orderBy('grade_level')->orderBy('class_number')->get();
        $selectedClasses = $tryout->classes->pluck('id')->toArray();

        return view('tentor.tryout.edit', compact('tryout', 'classes', 'selectedClasses'));
    }

    /**
     * Update the specified tryout
     */
    public function update(Request $request, $id)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tryouts,code,' . $tryout->id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_questions' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'classes' => 'required|array|min:1',
            'classes.*' => 'exists:classes,id',
        ]);

        $tryout->update([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_questions' => $validated['total_questions'],
            'duration_minutes' => $validated['duration_minutes'],
            'is_active' => $request->has('is_active'),
        ]);

        // Sync classes
        $tryout->classes()->sync($validated['classes']);

        return redirect()->route('tentor.tryout.index')
            ->with('success', 'Tryout berhasil diperbarui!');
    }

    /**
     * Remove the specified tryout
     */
    public function destroy($id)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($id);
        $tryout->delete();

        return redirect()->route('tentor.tryout.index')
            ->with('success', 'Tryout berhasil dihapus!');
    }

    /**
     * Show monitoring page for tryout results
     */
    public function monitor($id)
    {
        $tryout = Tryout::byCreator(Auth::id())
            ->with(['classes', 'users'])
            ->findOrFail($id);

        $completedStudents = $tryout->getCompletedStudents();
        $pendingStudents = $tryout->getPendingStudents();

        $stats = [
            'total_assigned' => $completedStudents->count() + $pendingStudents->count(),
            'completed' => $completedStudents->count(),
            'pending' => $pendingStudents->count(),
            'average_score' => $tryout->getAverageScore(),
            'completion_rate' => $tryout->getCompletionRate(),
        ];

        return view('tentor.tryout.monitor', compact('tryout', 'completedStudents', 'pendingStudents', 'stats'));
    }

    /**
     * Show individual student result
     */
    public function showResult($tryoutId, $studentId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);
        
        $student = $tryout->users()
            ->where('users.id', $studentId)
            ->wherePivot('status', 'sudah_dikerjakan')
            ->with('class')
            ->firstOrFail();

        return view('tentor.tryout.result', compact('tryout', 'student'));
    }
}