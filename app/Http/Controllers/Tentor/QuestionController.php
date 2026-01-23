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
    public function update(Request $request, Tryout $tryout, Question $question)
{
    // Cek ownership
    if ($tryout->created_by !== Auth::id()) {
        abort(403);
    }

    $validated = $request->validate([
        'question_text' => 'required|string',
        'question_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'explanation' => 'nullable|string',
        'answer_a_text' => 'required|string',
        'answer_b_text' => 'required|string',
        'answer_c_text' => 'required|string',
        'answer_d_text' => 'nullable|string',
        'answer_e_text' => 'nullable|string',
        'answer_a_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'answer_b_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'answer_c_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'answer_d_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'answer_e_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'correct_answer' => 'required|in:A,B,C,D,E',
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
        ]);

        // Update answers
        foreach ($question->answers as $answer) {
            $optionLower = strtolower($answer->option);
            
            // Skip if text is empty
            if (empty($validated["answer_{$optionLower}_text"])) {
                if ($answer->answer_image) {
                    \Storage::disk('public')->delete($answer->answer_image);
                }
                $answer->delete();
                continue;
            }
            
            // Handle answer image
            $answerImagePath = $answer->answer_image;
            if ($request->hasFile("answer_{$optionLower}_image")) {
                if ($answerImagePath) {
                    \Storage::disk('public')->delete($answerImagePath);
                }
                $answerImagePath = $request->file("answer_{$optionLower}_image")->store('answers', 'public');
            }
            
            // Update answer
            $answer->update([
                'answer_text' => $validated["answer_{$optionLower}_text"],
                'answer_image' => $answerImagePath,
                'is_correct' => $validated['correct_answer'] === $answer->option,
            ]);
        }

        DB::commit();
        return redirect()->route('tentor.question.index', $tryout->id)
            ->with('success', 'Soal berhasil diperbarui!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal memperbarui soal: ' . $e->getMessage());
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
    
    // Check if exceeding limit
    $currentCount = $tryout->getQuestionCount();
    $remainingSlots = $tryout->total_questions - $currentCount;
    
    if (count($request->questions ?? []) > $remainingSlots) {
        return back()
            ->withInput()
            ->with('error', "Tidak bisa menambah soal melebihi target! Sisa slot: {$remainingSlots} soal.");
    }
    
    // Validate
    $request->validate([
        'questions' => 'required|array|min:1',
        'questions.*.question_text' => 'nullable|string',
        'questions.*.answers' => 'nullable|array|min:3|max:5',
        'questions.*.answers.*' => 'nullable|string',
        'questions.*.correct_answer' => 'nullable|in:A,B,C,D,E',
        'questions.*.explanation' => 'nullable|string',
        'questions.*.points' => 'nullable|integer|min:1',
        // Validasi untuk images (terpisah dari questions array)
        'question_images.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'answer_images.*.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
    ]);

    $startNumber = $currentCount + 1;
    $savedCount = 0;
    $skippedCount = 0;

    DB::beginTransaction();
    try {
        foreach ($request->questions as $index => $questionData) {
            // Skip if question_text is empty
            if (empty($questionData['question_text'])) {
                $skippedCount++;
                continue;
            }

            // ✅ BENAR: Handle question image upload
            $questionImagePath = null;
            if ($request->hasFile("question_images.{$index}")) {
                $questionImagePath = $request->file("question_images.{$index}")
                    ->store('questions', 'public');
            }

            // Create question
            $question = Question::create([
                'tryout_id' => $tryout->id,
                'question_number' => $startNumber + $savedCount,
                'question_text' => $questionData['question_text'],
                'question_image' => $questionImagePath,
                'explanation' => $questionData['explanation'] ?? null,
                'points' => $questionData['points'] ?? 1, // default 1 poin
            ]);

            // Create answers if exists
            if (!empty($questionData['answers'])) {
                $options = ['A', 'B', 'C', 'D', 'E'];
                $answerCount = count($questionData['answers']);
                
                for ($idx = 0; $idx < $answerCount; $idx++) {
                    // Skip empty answers
                    if (empty($questionData['answers'][$idx])) {
                        continue;
                    }

                    $option = $options[$idx];
                    
                    // ✅ BENAR: Handle answer image upload
                    $answerImagePath = null;
                    if ($request->hasFile("answer_images.{$index}.{$idx}")) {
                        $answerImagePath = $request->file("answer_images.{$index}.{$idx}")
                            ->store('answers', 'public');
                    }

                    Answer::create([
                        'question_id' => $question->id,
                        'option' => $option,
                        'answer_text' => $questionData['answers'][$idx],
                        'answer_image' => $answerImagePath,
                        'is_correct' => isset($questionData['correct_answer']) && $questionData['correct_answer'] === $option,
                    ]);
                }
            }

            $savedCount++;
        }

        DB::commit();

        $message = "Berhasil menyimpan {$savedCount} soal!";
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} soal kosong dilewati)";
        }

        $newTotal = $tryout->getQuestionCount();
        if ($newTotal >= $tryout->total_questions) {
            $message .= " ✅ Tryout sudah lengkap dan bisa diakses student!";
        } else {
            $message .= " ⚠️ Masih butuh " . ($tryout->total_questions - $newTotal) . " soal lagi.";
        }

        return redirect()->route('tentor.question.index', $tryout->id)
            ->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Bulk store failed: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return back()
            ->withInput()
            ->with('error', 'Gagal menyimpan soal: ' . $e->getMessage());
    }
}
}