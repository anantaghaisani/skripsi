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
    /**
     * Display a listing of modules
     */
    public function index()
    {
        $tentor = Auth::user();
        
        $modules = Module::byCreator($tentor->id)
            ->with('classes')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tentor.module.index', compact('modules'));
    }

    /**
     * Show the form for creating a new module
     */
    public function create()
    {
        $classes = Classes::active()->orderBy('grade_level')->orderBy('class_number')->orderBy('name')->get();
        return view('tentor.module.create', compact('classes'));
    }

    /**
     * Store a newly created module
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'grade_level' => 'required|in:SD,SMP,SMA',
            'class_number' => 'required|integer|min:1|max:12',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            'classes' => 'required|array|min:1',
            'classes.*' => 'exists:classes,id',
        ]);

        // Upload cover image
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('module-covers', 'public');
        }

        // Upload PDF
        $pdfPath = $request->file('pdf_file')->store('module-pdfs', 'public');

        // Create module
        $module = Module::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'subject' => $validated['subject'],
            'grade_level' => $validated['grade_level'],
            'class_number' => $validated['class_number'],
            'cover_image' => $coverPath,
            'pdf_file' => $pdfPath,
            'views' => 0,
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        // Attach classes
        $module->classes()->attach($validated['classes']);

        return redirect()->route('tentor.module.index')
            ->with('success', 'Modul berhasil dibuat!');
    }

    /**
     * Show the form for editing the module
     */
    public function edit($id)
    {
        $module = Module::byCreator(Auth::id())->findOrFail($id);
        $classes = Classes::active()->orderBy('grade_level')->orderBy('class_number')->orderBy('name')->get();
        $selectedClasses = $module->classes->pluck('id')->toArray();

        return view('tentor.module.edit', compact('module', 'classes', 'selectedClasses'));
    }

    /**
     * Update the module
     */
    public function update(Request $request, $id)
    {
        $module = Module::byCreator(Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'grade_level' => 'required|in:SD,SMP,SMA',
            'class_number' => 'required|integer|min:1|max:12',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'is_active' => 'boolean',
            'classes' => 'required|array|min:1',
            'classes.*' => 'exists:classes,id',
        ]);

        // Upload new cover image if provided
        if ($request->hasFile('cover_image')) {
            // Delete old cover
            if ($module->cover_image && Storage::disk('public')->exists($module->cover_image)) {
                Storage::disk('public')->delete($module->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('module-covers', 'public');
        }

        // Upload new PDF if provided
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF
            if ($module->pdf_file && Storage::disk('public')->exists($module->pdf_file)) {
                Storage::disk('public')->delete($module->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('module-pdfs', 'public');
        }

        $module->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'subject' => $validated['subject'],
            'grade_level' => $validated['grade_level'],
            'class_number' => $validated['class_number'],
            'cover_image' => $validated['cover_image'] ?? $module->cover_image,
            'pdf_file' => $validated['pdf_file'] ?? $module->pdf_file,
            'is_active' => $request->has('is_active'),
        ]);

        // Sync classes
        $module->classes()->sync($validated['classes']);

        return redirect()->route('tentor.module.index')
            ->with('success', 'Modul berhasil diperbarui!');
    }

    /**
     * Remove the module
     */
    public function destroy($id)
    {
        $module = Module::byCreator(Auth::id())->findOrFail($id);

        // Delete files
        if ($module->cover_image && Storage::disk('public')->exists($module->cover_image)) {
            Storage::disk('public')->delete($module->cover_image);
        }
        if ($module->pdf_file && Storage::disk('public')->exists($module->pdf_file)) {
            Storage::disk('public')->delete($module->pdf_file);
        }

        $module->delete();

        return redirect()->route('tentor.module.index')
            ->with('success', 'Modul berhasil dihapus!');
    }
}