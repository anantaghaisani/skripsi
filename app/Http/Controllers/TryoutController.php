<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TryoutController extends Controller
{
    /**
     * Display list of available tryouts for student's class
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get tryouts for student's class that are active and have questions
        $tryouts = Tryout::active()
            ->forClass($user->class_id)
            ->whereHas('questions') // Only show tryouts with questions
            ->with(['classes', 'questions'])
            ->latest()
            ->get();

        // Get tryouts already completed by student
        $completedTryoutIds = $user->tryouts()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->pluck('tryouts.id')
            ->toArray();

        return view('student.tryout.index', compact('tryouts', 'completedTryoutIds'));
    }

    /**
     * Show token input page
     */
    public function show($id)
    {
        $tryout = Tryout::active()
            ->forClass(Auth::user()->class_id)
            ->whereHas('questions')
            ->with(['classes', 'questions'])
            ->findOrFail($id);

        // Check if already completed
        $userTryout = Auth::user()->tryouts()
            ->where('tryout_id', $tryout->id)
            ->first();

        $isCompleted = $userTryout && $userTryout->pivot->status === 'sudah_dikerjakan';

        return view('student.tryout.token-input', compact('tryout', 'isCompleted'));
    }

    /**
     * Verify token and start tryout
     */
    public function start(Request $request, $id)
    {
        $request->validate([
            'token' => 'required|string|size:6',
        ]);

        $tryout = Tryout::active()
            ->forClass(Auth::user()->class_id)
            ->whereHas('questions')
            ->findOrFail($id);

        // Verify token
        if (strtoupper($request->token) !== $tryout->token) {
            return back()->withErrors(['token' => 'Token tidak valid!']);
        }

        // Check if already completed
        $userTryout = Auth::user()->tryouts()
            ->where('tryout_id', $tryout->id)
            ->first();

        if ($userTryout && $userTryout->pivot->status === 'sudah_dikerjakan') {
            return redirect()->route('tryout.review', $tryout->id)
                ->with('info', 'Anda sudah menyelesaikan tryout ini. Silakan lihat review.');
        }

        // Create or update user_tryout record
        if (!$userTryout) {
            Auth::user()->tryouts()->attach($tryout->id, [
                'status' => 'sedang_dikerjakan',
                'started_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            Auth::user()->tryouts()->updateExistingPivot($tryout->id, [
                'status' => 'sedang_dikerjakan',
                'started_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('tryout.work', $tryout->id);
    }

    /**
     * Show exam page with questions
     */
    public function work($id)
    {
        $user = Auth::user();
        $tryout = Tryout::active()
            ->forClass($user->class_id)
            ->with(['questions.answers'])
            ->findOrFail($id);

        // Check if user has started this tryout
        $userTryout = $user->tryouts()
            ->where('tryout_id', $tryout->id)
            ->wherePivot('status', 'sedang_dikerjakan')
            ->first();

        if (!$userTryout) {
            return redirect()->route('tryout.show', $tryout->id)
                ->with('error', 'Silakan input token terlebih dahulu.');
        }

        // Get user's answers if any
        $userAnswers = UserAnswer::where('user_id', $user->id)
            ->where('tryout_id', $tryout->id)
            ->get()
            ->keyBy('question_id');

        // Calculate remaining time
        $startedAt = Carbon::parse($userTryout->pivot->started_at);
        $elapsedMinutes = $startedAt->diffInMinutes(now());
        $remainingMinutes = max(0, $tryout->duration_minutes - $elapsedMinutes);

        // Auto submit if time's up
        if ($remainingMinutes <= 0) {
            return $this->submit(new Request(), $tryout->id);
        }

        return view('student.tryout.work', compact('tryout', 'userAnswers', 'remainingMinutes'));
    }

    /**
     * Save answer (AJAX)
     */
    public function saveAnswer(Request $request, $id)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
        ]);

        $user = Auth::user();
        $question = Question::findOrFail($request->question_id);
        $answer = $question->answers()->findOrFail($request->answer_id);

        // Save or update answer
        UserAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'tryout_id' => $id,
                'question_id' => $request->question_id,
            ],
            [
                'answer_id' => $request->answer_id,
                'selected_option' => $answer->option,
                'is_correct' => $answer->is_correct,
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Submit tryout and calculate score
     */
    public function submit(Request $request, $id)
    {
        $user = Auth::user();
        $tryout = Tryout::with('questions')->findOrFail($id);

        // Check if already completed
        $userTryout = $user->tryouts()
            ->where('tryout_id', $tryout->id)
            ->first();

        if ($userTryout && $userTryout->pivot->status === 'sudah_dikerjakan') {
            return redirect()->route('tryout.review', $tryout->id)
                ->with('info', 'Anda sudah menyelesaikan tryout ini.');
        }

        // Calculate score
        $totalQuestions = $tryout->questions->count();
        $correctAnswers = UserAnswer::where('user_id', $user->id)
            ->where('tryout_id', $tryout->id)
            ->where('is_correct', true)
            ->count();

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        // Update user_tryout
        $user->tryouts()->updateExistingPivot($tryout->id, [
            'status' => 'sudah_dikerjakan',
            'score' => $score,
            'finished_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('tryout.result', $tryout->id)
            ->with('success', 'Tryout berhasil diselesaikan!');
    }

    /**
     * Show result page
     */
    public function result($id)
    {
        $user = Auth::user();
        $tryout = Tryout::findOrFail($id);

        $userTryout = $user->tryouts()
            ->where('tryout_id', $tryout->id)
            ->wherePivot('status', 'sudah_dikerjakan')
            ->firstOrFail();

        $score = $userTryout->pivot->score;
        $totalQuestions = $tryout->questions->count();
        $correctAnswers = UserAnswer::where('user_id', $user->id)
            ->where('tryout_id', $tryout->id)
            ->where('is_correct', true)
            ->count();
        $wrongAnswers = UserAnswer::where('user_id', $user->id)
            ->where('tryout_id', $tryout->id)
            ->where('is_correct', false)
            ->count();
        $unanswered = $totalQuestions - ($correctAnswers + $wrongAnswers);

        return view('student.tryout.result', compact(
            'tryout',
            'score',
            'totalQuestions',
            'correctAnswers',
            'wrongAnswers',
            'unanswered'
        ));
    }

    /**
     * Show review page with answers
     */
    public function review($id)
    {
        $user = Auth::user();
        $tryout = Tryout::with(['questions.answers'])->findOrFail($id);

        // Check if completed
        $userTryout = $user->tryouts()
            ->where('tryout_id', $tryout->id)
            ->wherePivot('status', 'sudah_dikerjakan')
            ->firstOrFail();

        // Get user answers
        $userAnswers = UserAnswer::where('user_id', $user->id)
            ->where('tryout_id', $tryout->id)
            ->with('answer')
            ->get()
            ->keyBy('question_id');

        return view('student.tryout.review', compact('tryout', 'userAnswers'));
    }
}