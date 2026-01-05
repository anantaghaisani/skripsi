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

        return redirect()->route('admin.tryout.index')
            ->with('success', 'Tryout berhasil dibuat dengan token: ' . $tryout->token);
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
        $tryout = Tryout::with(['classes', 'users', 'creator'])->findOrFail($id);

        $completedStudents = $tryout->users()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->with('class')
            ->get();

        $pendingStudents = $tryout->users()
            ->wherePivot('status', 'belum_dikerjakan')
            ->with('class')
            ->get();

        $stats = [
            'total_assigned' => $completedStudents->count() + $pendingStudents->count(),
            'completed' => $completedStudents->count(),
            'pending' => $pendingStudents->count(),
            'average_score' => $completedStudents->avg('user_tryouts.score') ?? 0,
            'completion_rate' => $completedStudents->count() > 0 ? 
                round(($completedStudents->count() / ($completedStudents->count() + $pendingStudents->count())) * 100) : 0,
        ];

        return view('admin.tryout.monitor', compact('tryout', 'completedStudents', 'pendingStudents', 'stats'));
    }
}