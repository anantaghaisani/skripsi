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
            'total_tryouts' => Tryout::count(),
            'completed_tryouts' => $user->tryouts()
                ->wherePivot('status', 'sudah_dikerjakan')
                ->count(),
            'pending_tryouts' => Tryout::query()
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
        $recentTryouts = Tryout::query()
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

        // Modul yang terakhir dibuka (3 terakhir berdasarkan updated_at)
        // Updated_at berubah ketika user view PDF (karena views di-increment)
        $recentModules = Module::active()
            ->when($user->grade_level, function($query) use ($user) {
                return $query->where('grade_level', $user->grade_level);
            })
            ->where('views', '>', 0) // Hanya modul yang pernah dibuka
            ->orderBy('updated_at', 'desc') // Urutkan berdasarkan terakhir diupdate
            ->take(4)
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