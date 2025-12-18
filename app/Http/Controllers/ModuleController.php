<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    /**
     * Display listing of modules based on user's grade
     */
    public function index()
    {
        $user = Auth::user();
        
        // Filter modul berdasarkan jenjang dan kelas user
        $modules = Module::active()
            ->when($user->grade_level, function($query) use ($user) {
                return $query->where('grade_level', $user->grade_level);
            })
            ->when($user->class_number, function($query) use ($user) {
                return $query->where('class_number', $user->class_number);
            })
            ->orderBy('subject')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group by subject
        $modulesBySubject = $modules->groupBy('subject');

        return view('modules.index', compact('modules', 'modulesBySubject', 'user'));
    }

    /**
     * Show module detail
     */
    public function show($id)
    {
        $module = Module::findOrFail($id);
        
        return view('modules.show', compact('module'));
    }

    /**
     * View PDF module
     */
    public function viewPdf($id)
    {
        $module = Module::findOrFail($id);
        
        // Increment views
        $module->incrementViews();
        
        // Path file PDF
        $pdfPath = storage_path('app/public/' . $module->pdf_file);
        
        // Check if file exists
        if (!file_exists($pdfPath)) {
            abort(404, 'File PDF tidak ditemukan');
        }
        
        // Return PDF untuk ditampilkan di browser
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $module->title . '.pdf"'
        ]);
    }

    /**
     * Download PDF module
     */
    public function downloadPdf($id)
    {
        $module = Module::findOrFail($id);
        
        $pdfPath = storage_path('app/public/' . $module->pdf_file);
        
        if (!file_exists($pdfPath)) {
            abort(404, 'File PDF tidak ditemukan');
        }
        
        return response()->download($pdfPath, $module->title . '.pdf');
    }
}