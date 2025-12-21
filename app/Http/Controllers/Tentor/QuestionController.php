<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Show questions for a tryout
     */
    public function index($tryoutId)
    {
        $tryout = Tryout::byCreator(Auth::id())
            ->with('questions.answers')
            ->findOrFail($tryoutId);

        return view('tentor.question.index', compact('tryout'));
    }

    /**
     * Show form to add questions
     */
    public function create($tryoutId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);
        
        // Get next question number
        $nextNumber = $tryout->questions()->max('question_number') + 1;

        return view('tentor.question.create', compact('tryout', 'nextNumber'));
    }

    /**
     * Store new question with answers
     */
    public function store(Request $request, $tryoutId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);

        $validated = $request->validate([
            'question_number' => 'required|integer|min:1',
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'answers' => 'required|array|size:5', // Harus ada 5 jawaban (A-E)
            'answers.*.text' => 'required|string',
            'answers.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        DB::beginTransaction();
        try {
            // Upload question image if exists
            $questionImagePath = null;
            if ($request->hasFile('question_image')) {
                $questionImagePath = $request->file('question_image')->store('question-images', 'public');
            }

            // Create question
            $question = Question::create([
                'tryout_id' => $tryout->id,
                'question_number' => $validated['question_number'],
                'question_text' => $validated['question_text'],
                'question_image' => $questionImagePath,
                'explanation' => $validated['explanation'],
                'points' => $validated['points'],
            ]);

            // Create answers (A, B, C, D, E)
            $options = ['A', 'B', 'C', 'D', 'E'];
            foreach ($options as $index => $option) {
                $answerImagePath = null;
                if ($request->hasFile("answers.{$index}.image")) {
                    $answerImagePath = $request->file("answers.{$index}.image")->store('answer-images', 'public');
                }

                Answer::create([
                    'question_id' => $question->id,
                    'option' => $option,
                    'answer_text' => $validated['answers'][$index]['text'],
                    'answer_image' => $answerImagePath,
                    'is_correct' => ($option === $validated['correct_answer']),
                ]);
            }

            DB::commit();

            return redirect()->route('tentor.question.index', $tryout->id)
                ->with('success', 'Soal berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal menambahkan soal: ' . $e->getMessage());
        }
    }

    /**
     * Show form to edit question
     */
    public function edit($tryoutId, $questionId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);
        $question = Question::where('tryout_id', $tryout->id)
            ->with('answers')
            ->findOrFail($questionId);

        return view('tentor.question.edit', compact('tryout', 'question'));
    }

    /**
     * Update question
     */
    public function update(Request $request, $tryoutId, $questionId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);
        $question = Question::where('tryout_id', $tryout->id)->findOrFail($questionId);

        $validated = $request->validate([
            'question_number' => 'required|integer|min:1',
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'answers' => 'required|array|size:5',
            'answers.*.text' => 'required|string',
            'answers.*.image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        DB::beginTransaction();
        try {
            // Upload new question image if provided
            if ($request->hasFile('question_image')) {
                // Delete old image
                if ($question->question_image && Storage::disk('public')->exists($question->question_image)) {
                    Storage::disk('public')->delete($question->question_image);
                }
                $validated['question_image'] = $request->file('question_image')->store('question-images', 'public');
            }

            // Update question
            $question->update([
                'question_number' => $validated['question_number'],
                'question_text' => $validated['question_text'],
                'question_image' => $validated['question_image'] ?? $question->question_image,
                'explanation' => $validated['explanation'],
                'points' => $validated['points'],
            ]);

            // Update answers
            $options = ['A', 'B', 'C', 'D', 'E'];
            $answers = $question->answers()->orderBy('option')->get();

            foreach ($options as $index => $option) {
                $answer = $answers[$index];
                
                $answerData = [
                    'answer_text' => $validated['answers'][$index]['text'],
                    'is_correct' => ($option === $validated['correct_answer']),
                ];

                // Upload new answer image if provided
                if ($request->hasFile("answers.{$index}.image")) {
                    // Delete old image
                    if ($answer->answer_image && Storage::disk('public')->exists($answer->answer_image)) {
                        Storage::disk('public')->delete($answer->answer_image);
                    }
                    $answerData['answer_image'] = $request->file("answers.{$index}.image")->store('answer-images', 'public');
                }

                $answer->update($answerData);
            }

            DB::commit();

            return redirect()->route('tentor.question.index', $tryout->id)
                ->with('success', 'Soal berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal memperbarui soal: ' . $e->getMessage());
        }
    }

    /**
     * Delete question
     */
    public function destroy($tryoutId, $questionId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);
        $question = Question::where('tryout_id', $tryout->id)->findOrFail($questionId);

        // Delete images
        if ($question->question_image && Storage::disk('public')->exists($question->question_image)) {
            Storage::disk('public')->delete($question->question_image);
        }

        foreach ($question->answers as $answer) {
            if ($answer->answer_image && Storage::disk('public')->exists($answer->answer_image)) {
                Storage::disk('public')->delete($answer->answer_image);
            }
        }

        $question->delete();

        return redirect()->route('tentor.question.index', $tryout->id)
            ->with('success', 'Soal berhasil dihapus!');
    }

    /**
     * Bulk add questions form
     */
    public function bulkCreate($tryoutId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);
        
        // Get next question number
        $startNumber = $tryout->questions()->max('question_number') + 1;

        return view('tentor.question.bulk-create', compact('tryout', 'startNumber'));
    }

    /**
     * Store bulk questions
     */
    public function bulkStore(Request $request, $tryoutId)
    {
        $tryout = Tryout::byCreator(Auth::id())->findOrFail($tryoutId);

        $validated = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.explanation' => 'nullable|string',
            'questions.*.answers' => 'required|array|size:5',
            'questions.*.answers.*' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        DB::beginTransaction();
        try {
            $startNumber = $tryout->questions()->max('question_number') + 1;

            foreach ($validated['questions'] as $index => $questionData) {
                // Create question
                $question = Question::create([
                    'tryout_id' => $tryout->id,
                    'question_number' => $startNumber + $index,
                    'question_text' => $questionData['question_text'],
                    'explanation' => $questionData['explanation'] ?? null,
                    'points' => 1,
                ]);

                // Create answers
                $options = ['A', 'B', 'C', 'D', 'E'];
                foreach ($options as $optionIndex => $option) {
                    Answer::create([
                        'question_id' => $question->id,
                        'option' => $option,
                        'answer_text' => $questionData['answers'][$optionIndex],
                        'is_correct' => ($option === $questionData['correct_answer']),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('tentor.question.index', $tryout->id)
                ->with('success', count($validated['questions']) . ' soal berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                ->with('error', 'Gagal menambahkan soal: ' . $e->getMessage());
        }
    }
}