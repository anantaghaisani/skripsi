<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Tryout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Stats
        $stats = [
            'total_tryouts' => Tryout::active()->count(),
            'completed_tryouts' => $user->tryouts()
                ->wherePivot('status', 'sudah_dikerjakan')
                ->count(),
            'pending_tryouts' => Tryout::active()
                ->whereDoesntHave('users', function($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->where('status', 'sudah_dikerjakan');
                })
                ->count(),
            'total_modules' => Module::active()
                ->when($user->grade_level, function($query) use ($user) {
                    return $query->where('grade_level', $user->grade_level);
                })
                ->count(),
        ];

        // Tryout terbaru yang belum dikerjakan (3 terakhir)
        $recentTryouts = Tryout::active()
            ->whereDoesntHave('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Tryout yang baru selesai dikerjakan (3 terakhir)
        $completedTryouts = $user->tryouts()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->orderByPivot('finished_at', 'desc')
            ->take(3)
            ->get();

        // Modul yang baru dilihat/populer (berdasarkan views)
        $recentModules = Module::active()
            ->when($user->grade_level, function($query) use ($user) {
                return $query->where('grade_level', $user->grade_level);
            })
            ->orderBy('views', 'desc')
            ->take(6)
            ->get();

        // Average score dari tryout yang sudah dikerjakan
        $averageScore = $user->tryouts()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->avg('user_tryouts.score');

        return view('dashboard.index', compact(
            'stats',
            'recentTryouts',
            'completedTryouts',
            'recentModules',
            'averageScore',
            'user'
        ));
    }
}