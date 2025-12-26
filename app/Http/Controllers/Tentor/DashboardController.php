<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tentor = Auth::user();

        // Stats untuk tentor
        $stats = [
            'total_tryouts' => Tryout::where('created_by', $tentor->id)->count(),
            'active_tryouts' => Tryout::where('created_by', $tentor->id)->where('is_active', true)->count(),
            'total_modules' => Module::where('created_by', $tentor->id)->count(),
            'total_students' => User::where('role', 'student')->count(),
        ];

        // Tryout terbaru yang dibuat tentor (5 terakhir)
        $recentTryouts = Tryout::where('created_by', $tentor->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Module terbaru yang dibuat tentor (3 terakhir)
        $recentModules = Module::where('created_by', $tentor->id)
            ->latest()
            ->take(3)
            ->get();

        // Tryout dengan completion rate tertinggi
        $popularTryouts = Tryout::where('created_by', $tentor->id)
            ->with('users')
            ->get()
            ->map(function($tryout) {
                $totalStudents = $tryout->users()->count();
                $completedCount = $tryout->users()->wherePivot('status', 'sudah_dikerjakan')->count();
                
                return [
                    'tryout' => $tryout,
                    'completion_rate' => $totalStudents > 0 ? round(($completedCount / $totalStudents) * 100) : 0,
                    'completed_count' => $completedCount,
                ];
            })
            ->sortByDesc('completed_count')
            ->take(5);

        return view('tentor.dashboard', compact(
            'stats',
            'recentTryouts',
            'recentModules',
            'popularTryouts',
            'tentor'
        ));
    }
}