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
            'total_tryouts' => Tryout::byCreator($tentor->id)->count(),
            'active_tryouts' => Tryout::byCreator($tentor->id)->active()->count(),
            'total_modules' => Module::byCreator($tentor->id)->count(),
            'total_students' => User::students()->count(),
        ];

        // Tryout terbaru yang dibuat tentor (5 terakhir)
        $recentTryouts = Tryout::byCreator($tentor->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Module terbaru yang dibuat tentor (5 terakhir)
        $recentModules = Module::byCreator($tentor->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Tryout dengan completion rate tertinggi
        $popularTryouts = Tryout::byCreator($tentor->id)
            ->with('users')
            ->get()
            ->map(function($tryout) {
                return [
                    'tryout' => $tryout,
                    'completion_rate' => $tryout->getCompletionRate(),
                    'completed_count' => $tryout->users()->wherePivot('status', 'sudah_dikerjakan')->count(),
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