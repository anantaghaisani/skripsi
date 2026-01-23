<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryoutController extends Controller
{
    /**
     * Display ALL tryouts (not just own)
     */
    public function index(Request $request)
    {
        $query = Tryout::with(['classes', 'creator']);

        // Filter by creator (tentor)
        if ($request->filled('creator_id')) {
            $query->where('created_by', $request->creator_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $tryouts = $query->latest()->paginate(10);

        // Get all tentors for filter
        $creators = User::where('role', 'tentor')->get();

        return view('admin.tryout.index', compact('tryouts', 'creators'));
    }

    /**
     * Show the form for creating a new tryout
     */
    public function create()
    {
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();
        
        return view('admin.tryout.create', compact('classes'));
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

        // Create tryout
        $tryout = Tryout::create([
            'title' => $validated['title'],
            'code' => $validated['code'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_questions' => $validated['total_questions'],
            'duration_minutes' => $validated['duration_minutes'],
            'is_active' => true,
            'created_by' => Auth::id(), // Admin as creator
        ]);

        // Attach classes
        $tryout->classes()->attach($validated['classes']);

        // REDIRECT KE BULK ADD SOAL
        return redirect()->route('admin.question.bulk-create', $tryout->id)
            ->with('success', 'Tryout berhasil dibuat dengan token: ' . $tryout->token . '. Silakan tambahkan soal sekarang.');
    }

    /**
     * Display the specified tryout
     */
    public function show($id)
    {
        $tryout = Tryout::with(['classes', 'creator', 'questions'])->findOrFail($id);
        
        return view('admin.tryout.show', compact('tryout'));
    }

    /**
     * Show the form for editing ANY tryout
     */
    public function edit($id)
    {
        $tryout = Tryout::with('classes')->findOrFail($id);
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();
        $selectedClasses = $tryout->classes->pluck('id')->toArray();

        return view('admin.tryout.edit', compact('tryout', 'classes', 'selectedClasses'));
    }

    /**
     * Update ANY tryout
     */
    public function update(Request $request, $id)
    {
        $tryout = Tryout::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tryouts,code,' . $tryout->id,
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_questions' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:1',
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
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Sync classes
        $tryout->classes()->sync($validated['classes']);

        return redirect()->route('admin.tryout.index')
            ->with('success', 'Tryout berhasil diperbarui!');
    }

    /**
     * Remove ANY tryout
     */
    public function destroy($id)
    {
        $tryout = Tryout::findOrFail($id);
        $tryout->delete();

        return redirect()->route('admin.tryout.index')
            ->with('success', 'Tryout berhasil dihapus!');
    }

    /**
     * Toggle tryout status (active/inactive)
     */
    public function toggleStatus($id)
    {
        $tryout = Tryout::findOrFail($id);
        $tryout->update(['is_active' => !$tryout->is_active]);

        return back()->with('success', 'Status tryout berhasil diubah!');
    }

    /**
     * Show monitoring page for ANY tryout
     */
    public function monitor($id)
    {
        $tryout = Tryout::with(['classes', 'creator'])->findOrFail($id);

        // ✅ PAKAI METHOD DARI MODEL (SAMA KAYAK TENTOR)
        $completedStudents = $tryout->getCompletedStudents();
        $pendingStudents = $tryout->getPendingStudents();

        $stats = [
            'total_assigned' => $completedStudents->count() + $pendingStudents->count(),
            'completed' => $completedStudents->count(),
            'pending' => $pendingStudents->count(),
            'average_score' => $tryout->getAverageScore(),
            'completion_rate' => $tryout->getCompletionRate(),
        ];

        return view('admin.tryout.monitor', compact('tryout', 'completedStudents', 'pendingStudents', 'stats'));
    }

    /**
     * Show individual student result
     */
    public function showResult($tryoutId, $studentId)
    {
        $tryout = Tryout::with(['questions.answers'])->findOrFail($tryoutId);
        
        $student = $tryout->users()
            ->where('users.id', $studentId)
            ->wherePivot('status', 'sudah_dikerjakan')
            ->with('class')
            ->firstOrFail();

        // Get user answers
        $userAnswers = \App\Models\UserAnswer::where('user_id', $studentId)
            ->where('tryout_id', $tryoutId)
            ->with('answer')
            ->get()
            ->keyBy('question_id');

        return view('admin.tryout.result', compact('tryout', 'student', 'userAnswers'));
    }
}