<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tryout;
use App\Models\Module;
use App\Models\Classes;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Overall Stats
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_tentors' => User::where('role', 'tentor')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_classes' => Classes::count(),
            'total_tryouts' => Tryout::count(),
            'active_tryouts' => Tryout::where('is_active', true)->count(),
            'total_modules' => Module::count(),
            'active_modules' => Module::where('is_active', true)->count(),
            'total_questions' => Question::count(),
        ];

        // Recent Activities
        $recentUsers = User::latest()->take(5)->get();
        $recentTryouts = Tryout::with('creator')->latest()->take(5)->get();
        $recentModules = Module::with('creator')->latest()->take(5)->get();

        // Tryout Statistics
        $tryoutStats = Tryout::select('title', 'id')
            ->withCount(['users as total_participants'])
            ->orderBy('total_participants', 'desc')
            ->take(5)
            ->get();

        // Class Distribution
        $classStats = Classes::withCount('students')
            ->orderBy('grade_level')
            ->orderBy('class_number')
            ->get();

        // Monthly User Registration (last 6 months)
        $monthlyUsers = User::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentTryouts',
            'recentModules',
            'tryoutStats',
            'classStats',
            'monthlyUsers'
        ));
    }
}