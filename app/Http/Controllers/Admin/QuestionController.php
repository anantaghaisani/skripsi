<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions for a tryout.
     */
    public function index(Tryout $tryout)
    {
        $tryout->load(['questions.answers']);
        
        return view('admin.question.index', compact('tryout'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create(Tryout $tryout)
    {
        $nextQuestionNumber = $tryout->questions()->max('question_number') + 1;
        
        return view('admin.question.create', compact('tryout', 'nextQuestionNumber'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request, Tryout $tryout)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|max:2048',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'answers' => 'required|array|min:2',
            'answers.*.answer_text' => 'required|string',
            'answers.*.answer_image' => 'nullable|image|max:2048',
            'answers.*.is_correct' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Get next question number
            $questionNumber = $tryout->questions()->max('question_number') + 1;

            // Handle question image upload
            $questionImagePath = null;
            if ($request->hasFile('question_image')) {
                $questionImagePath = $request->file('question_image')->store('questions', 'public');
            }

            // Create question
            $question = $tryout->questions()->create([
                'question_number' => $questionNumber,
                'question_text' => $validated['question_text'],
                'question_image' => $questionImagePath,
                'explanation' => $validated['explanation'] ?? null,
                'points' => $validated['points'],
            ]);

            // Create answers
            $options = ['A', 'B', 'C', 'D', 'E'];
            foreach ($validated['answers'] as $index => $answerData) {
                $answerImagePath = null;
                if (isset($request->file('answers')[$index]['answer_image'])) {
                    $answerImagePath = $request->file('answers')[$index]['answer_image']->store('answers', 'public');
                }

                $question->answers()->create([
                    'option' => $options[$index] ?? chr(65 + $index),
                    'answer_text' => $answerData['answer_text'],
                    'answer_image' => $answerImagePath,
                    'is_correct' => isset($answerData['is_correct']) && $answerData['is_correct'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.question.index', $tryout->id)
                ->with('success', 'Soal berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan soal: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for bulk creating questions.
     */
    public function bulkCreate(Tryout $tryout)
    {
        $startNumber = $tryout->questions()->max('question_number') + 1;
        
        return view('admin.question.bulk-create', compact('tryout', 'startNumber'));
    }

    /**
     * Store multiple questions at once.
     */
    public function bulkStore(Request $request, Tryout $tryout)
    {
        $validated = $request->validate([
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.answers' => 'required|array|size:5',
            'questions.*.answers.*' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
            'questions.*.explanation' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $startNumber = $tryout->questions()->max('question_number') + 1;
            $createdCount = 0;

            foreach ($validated['questions'] as $questionData) {
                // Skip empty questions
                if (empty(trim($questionData['question_text']))) {
                    continue;
                }

                // Create question
                $question = $tryout->questions()->create([
                    'question_number' => $startNumber + $createdCount,
                    'question_text' => $questionData['question_text'],
                    'explanation' => $questionData['explanation'] ?? null,
                    'points' => 1, // Default points
                ]);

                // Create answers
                $options = ['A', 'B', 'C', 'D', 'E'];
                foreach ($questionData['answers'] as $index => $answerText) {
                    $question->answers()->create([
                        'option' => $options[$index],
                        'answer_text' => $answerText,
                        'is_correct' => $options[$index] === $questionData['correct_answer'],
                    ]);
                }

                $createdCount++;
            }

            DB::commit();
            return redirect()->route('admin.question.index', $tryout->id)
                ->with('success', "$createdCount soal berhasil ditambahkan!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan soal: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Tryout $tryout, Question $question)
    {
        $question->load('answers');
        
        return view('admin.question.edit', compact('tryout', 'question'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, Tryout $tryout, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_image' => 'nullable|image|max:2048',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'answers' => 'required|array|min:2',
            'answers.*.answer_text' => 'required|string',
            'answers.*.answer_image' => 'nullable|image|max:2048',
            'answers.*.is_correct' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Handle question image upload
            $questionImagePath = $question->question_image;
            if ($request->hasFile('question_image')) {
                // Delete old image if exists
                if ($questionImagePath) {
                    \Storage::disk('public')->delete($questionImagePath);
                }
                $questionImagePath = $request->file('question_image')->store('questions', 'public');
            }

            // Update question
            $question->update([
                'question_text' => $validated['question_text'],
                'question_image' => $questionImagePath,
                'explanation' => $validated['explanation'] ?? null,
                'points' => $validated['points'],
            ]);

            // Delete old answers
            $question->answers()->delete();

            // Create new answers
            $options = ['A', 'B', 'C', 'D', 'E'];
            foreach ($validated['answers'] as $index => $answerData) {
                $answerImagePath = null;
                if (isset($request->file('answers')[$index]['answer_image'])) {
                    $answerImagePath = $request->file('answers')[$index]['answer_image']->store('answers', 'public');
                }

                $question->answers()->create([
                    'option' => $options[$index] ?? chr(65 + $index),
                    'answer_text' => $answerData['answer_text'],
                    'answer_image' => $answerImagePath,
                    'is_correct' => isset($answerData['is_correct']) && $answerData['is_correct'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.question.index', $tryout->id)
                ->with('success', 'Soal berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui soal: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(Tryout $tryout, Question $question)
    {
        try {
            // Delete images if exists
            if ($question->question_image) {
                \Storage::disk('public')->delete($question->question_image);
            }
            
            foreach ($question->answers as $answer) {
                if ($answer->answer_image) {
                    \Storage::disk('public')->delete($answer->answer_image);
                }
            }

            $question->delete();

            return redirect()->route('admin.question.index', $tryout->id)
                ->with('success', 'Soal berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus soal: ' . $e->getMessage());
        }
    }
}