<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get tryouts for student's class that are active and COMPLETE
        $totalTryouts = Tryout::active()
            ->forClass($user->class_id)
            ->whereRaw('(SELECT COUNT(*) FROM questions WHERE tryout_id = tryouts.id) >= tryouts.total_questions')
            ->count();

        // Get completed tryouts IDs first
        $completedTryoutIds = $user->tryouts()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->pluck('tryouts.id')
            ->toArray();

        // Get completed tryouts count
        $completedTryouts = count($completedTryoutIds);

        // Calculate average score from completed tryouts
        $averageScore = $user->tryouts()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->avg('user_tryouts.score') ?? 0;

        // Get recent tryouts that are NOT completed (limit 3) - ONLY COMPLETE ONES
        $recentTryouts = Tryout::active()
            ->forClass($user->class_id)
            ->whereRaw('(SELECT COUNT(*) FROM questions WHERE tryout_id = tryouts.id) >= tryouts.total_questions')
            ->whereNotIn('id', $completedTryoutIds)
            ->with(['classes', 'questions'])
            ->latest()
            ->limit(3)
            ->get();

        // Get completed tryouts with score (limit 3)
        $completedTryoutsList = Tryout::whereIn('id', $completedTryoutIds)
            ->with(['classes', 'questions'])
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($tryout) use ($user) {
                $userTryout = $user->tryouts()->where('tryout_id', $tryout->id)->first();
                $tryout->user_score = $userTryout ? $userTryout->pivot->score : 0;
                $tryout->finished_at = $userTryout ? $userTryout->pivot->finished_at : null;
                return $tryout;
            });

        // Get available modules for student's class
        $totalModules = Module::forClass($user->class_id)
            ->count();

        // Get recent modules (limit 3)
        $recentModules = Module::forClass($user->class_id)
            ->with('classes')
            ->latest()
            ->limit(3)
            ->get();

        return view('dashboard.index', compact(
            'totalTryouts',
            'completedTryouts',
            'averageScore',
            'recentTryouts',
            'completedTryoutIds',
            'completedTryoutsList',
            'totalModules',
            'recentModules'
        ));
    }
}