<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Module::with(['classes'])
            ->where('created_by', Auth::id());

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Filter by class
        if ($request->class_id) {
            $query->whereHas('classes', function($q) use ($request) {
                $q->where('classes.id', $request->class_id);
            });
        }

        // Filter by status
        if ($request->is_active !== null && $request->is_active !== '') {
            $query->where('is_active', $request->is_active);
        }

        $modules = $query->latest()->paginate(10);
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();

        return view('tentor.modules.index', compact('modules', 'classes'));
    }

    public function create()
    {
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();
        return view('tentor.modules.create', compact('classes'));
    }

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

        $filePath = $request->file('file')->store('modules', 'public');
        $thumbnailPath = $request->hasFile('thumbnail') 
            ? $request->file('thumbnail')->store('module-thumbnails', 'public') 
            : null;

        $module = Module::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $filePath,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
            'file_size' => $request->file('file')->getSize(),
            'thumbnail' => $thumbnailPath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_by' => Auth::id(),
        ]);

        $module->classes()->attach($validated['class_ids']);

        return redirect()->route('tentor.modules.index')
            ->with('success', 'Modul berhasil ditambahkan!');
    }

    public function show($id)
    {
        $module = Module::with(['classes', 'creator'])
            ->where('created_by', Auth::id())
            ->findOrFail($id);

        return view('tentor.modules.show', compact('module'));
    }

    public function edit($id)
    {
        $module = Module::with('classes')->where('created_by', Auth::id())->findOrFail($id);
        $classes = Classes::orderBy('grade_level')->orderBy('class_number')->get();

        return view('tentor.modules.edit', compact('module', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::where('created_by', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,avi,mov|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'class_ids' => 'required|array|min:1',
            'class_ids.*' => 'exists:classes,id',
        ]);

        if ($request->hasFile('file')) {
            if ($module->file_path) Storage::disk('public')->delete($module->file_path);
            $module->file_path = $request->file('file')->store('modules', 'public');
            $module->file_type = $request->file('file')->getClientOriginalExtension();
            $module->file_size = $request->file('file')->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            if ($module->thumbnail) Storage::disk('public')->delete($module->thumbnail);
            $module->thumbnail = $request->file('thumbnail')->store('module-thumbnails', 'public');
        }

        $module->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $module->classes()->sync($validated['class_ids']);

        return redirect()->route('tentor.modules.index')
            ->with('success', 'Modul berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $module = Module::where('created_by', Auth::id())->findOrFail($id);

        if ($module->file_path) Storage::disk('public')->delete($module->file_path);
        if ($module->thumbnail) Storage::disk('public')->delete($module->thumbnail);

        $module->delete();

        return redirect()->route('tentor.modules.index')
            ->with('success', 'Modul berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $module = Module::where('created_by', Auth::id())->findOrFail($id);
        $module->is_active = !$module->is_active;
        $module->save();

        return response()->json([
            'success' => true,
            'message' => 'Status modul berhasil diubah!',
            'is_active' => $module->is_active
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'module_ids' => 'required|array|min:1',
            'module_ids.*' => 'exists:modules,id',
        ]);

        $modules = Module::where('created_by', Auth::id())
            ->whereIn('id', $validated['module_ids'])
            ->get();

        foreach ($modules as $module) {
            if ($module->file_path) Storage::disk('public')->delete($module->file_path);
            if ($module->thumbnail) Storage::disk('public')->delete($module->thumbnail);
            $module->delete();
        }

        return redirect()->route('tentor.modules.index')
            ->with('success', count($modules) . ' modul berhasil dihapus!');
    }
}