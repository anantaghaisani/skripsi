<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Display ALL modules (not just own)
     */
    public function index(Request $request)
    {
        $query = Module::with(['classes', 'creator']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by creator (tentor)
        if ($request->filled('creator_id')) {
            $query->where('created_by', $request->creator_id);
        }

        // Filter by class
        if ($request->filled('class_id')) {
            $query->whereHas('classes', function($q) use ($request) {
                $q->where('classes.id', $request->class_id);
            });
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $modules = $query->latest()->paginate(12);

        // Get filters data
        $creators = User::where('role', 'tentor')->get();
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();

        return view('admin.module.index', compact('modules', 'creators', 'classes'));
    }

    /**
     * Show the form for creating a new module
     */
    public function create()
    {
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();
        return view('admin.module.create', compact('classes'));
    }

    /**
     * Store a newly created module
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,mp4,avi,mov|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'class_ids' => 'required|array|min:1',
            'class_ids.*' => 'exists:classes,id',
        ]);

        // Upload file
        $filePath = $request->file('file')->store('modules', 'public');
        $fileType = $request->file('file')->getClientOriginalExtension();
        $fileSize = $request->file('file')->getSize();

        // Upload thumbnail (optional)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('module-thumbnails', 'public');
        }

        // Create module
        $module = Module::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'thumbnail' => $thumbnailPath,
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        // Attach classes
        $module->classes()->attach($validated['class_ids']);

        return redirect()->route('admin.module.index')
            ->with('success', 'Modul berhasil ditambahkan!');
    }

    /**
     * Display the specified module
     */
    public function show($id)
    {
        $module = Module::with(['classes', 'creator'])->findOrFail($id);
        
        return view('admin.module.show', compact('module'));
    }

    /**
     * Show the form for editing ANY module
     */
    public function edit($id)
    {
        $module = Module::with('classes')->findOrFail($id);
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();
        $selectedClasses = $module->classes->pluck('id')->toArray();

        return view('admin.module.edit', compact('module', 'classes', 'selectedClasses'));
    }

    /**
     * Update ANY module
     */
    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,avi,mov|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'class_ids' => 'required|array|min:1',
            'class_ids.*' => 'exists:classes,id',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => $request->has('is_active'),
        ];

        // Update file if uploaded
        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($module->file_path)) {
                Storage::disk('public')->delete($module->file_path);
            }

            $data['file_path'] = $request->file('file')->store('modules', 'public');
            $data['file_type'] = $request->file('file')->getClientOriginalExtension();
            $data['file_size'] = $request->file('file')->getSize();
        }

        // Update thumbnail if uploaded
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($module->thumbnail && Storage::disk('public')->exists($module->thumbnail)) {
                Storage::disk('public')->delete($module->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('module-thumbnails', 'public');
        }

        $module->update($data);

        // Sync classes
        $module->classes()->sync($validated['class_ids']);

        return redirect()->route('admin.module.index')
            ->with('success', 'Modul berhasil diperbarui!');
    }

    /**
     * Remove ANY module
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);

        // Delete files
        if (Storage::disk('public')->exists($module->file_path)) {
            Storage::disk('public')->delete($module->file_path);
        }
        if ($module->thumbnail && Storage::disk('public')->exists($module->thumbnail)) {
            Storage::disk('public')->delete($module->thumbnail);
        }

        $module->delete();

        return redirect()->route('admin.module.index')
            ->with('success', 'Modul berhasil dihapus!');
    }

    /**
     * Toggle module status (active/inactive)
     */
    public function toggleStatus($id)
    {
        $module = Module::findOrFail($id);
        $module->update(['is_active' => !$module->is_active]);

        return back()->with('success', 'Status modul berhasil diubah!');
    }

    /**
     * Bulk delete modules
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'module_ids' => 'required|array',
            'module_ids.*' => 'exists:modules,id',
        ]);

        $modules = Module::whereIn('id', $validated['module_ids'])->get();

        foreach ($modules as $module) {
            // Delete files
            if (Storage::disk('public')->exists($module->file_path)) {
                Storage::disk('public')->delete($module->file_path);
            }
            if ($module->thumbnail && Storage::disk('public')->exists($module->thumbnail)) {
                Storage::disk('public')->delete($module->thumbnail);
            }

            $module->delete();
        }

        return back()->with('success', count($validated['module_ids']) . ' modul berhasil dihapus!');
    }
}