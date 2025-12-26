<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tryout;
use App\Models\Question;
use App\Models\Answer;

class SampleTryoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create tryout
        $tryout = Tryout::where('code', 'TO-SAMPLE-001')->first();
        
        if (!$tryout) {
            $tryout = Tryout::create([
                'title' => 'Tryout Matematika Dasar',
                'code' => 'TO-SAMPLE-001',
                'token' => 'TEST01',
                'description' => 'Tryout latihan matematika dasar untuk SMP kelas 7',
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(30),
                'total_questions' => 20,
                'duration_minutes' => 20,
                'is_active' => true,
                'created_by' => 1, // Admin/Tentor pertama
            ]);

            // Attach to class SMP 7A (class_id = 1)
            $tryout->classes()->attach([1]);

            echo "✅ Tryout created: {$tryout->title}\n";
        }

        // Clear existing questions for this tryout
        $tryout->questions()->delete();

        // Questions data
        $questions = [
            // Question 1
            [
                'question_text' => 'Hasil dari 15 + 23 - 8 adalah...',
                'explanation' => 'Kerjakan operasi dari kiri ke kanan: 15 + 23 = 38, kemudian 38 - 8 = 30',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '25', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '30', 'is_correct' => true],
                    ['option' => 'C', 'answer_text' => '35', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '38', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '40', 'is_correct' => false],
                ]
            ],
            // Question 2
            [
                'question_text' => 'Jika x + 5 = 12, maka nilai x adalah...',
                'explanation' => 'x + 5 = 12, maka x = 12 - 5 = 7',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '5', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '6', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '7', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '8', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '9', 'is_correct' => false],
                ]
            ],
            // Question 3
            [
                'question_text' => 'Hasil dari 6 × 7 adalah...',
                'explanation' => '6 × 7 = 42',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '36', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '40', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '42', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '48', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '54', 'is_correct' => false],
                ]
            ],
            // Question 4
            [
                'question_text' => 'Keliling persegi dengan sisi 8 cm adalah...',
                'explanation' => 'Keliling persegi = 4 × sisi = 4 × 8 = 32 cm',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '16 cm', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '24 cm', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '32 cm', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '40 cm', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '64 cm', 'is_correct' => false],
                ]
            ],
            // Question 5
            [
                'question_text' => 'Hasil dari 48 ÷ 6 adalah...',
                'explanation' => '48 ÷ 6 = 8',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '6', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '7', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '8', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '9', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '10', 'is_correct' => false],
                ]
            ],
            // Question 6
            [
                'question_text' => 'Luas persegi panjang dengan panjang 12 cm dan lebar 5 cm adalah...',
                'explanation' => 'Luas = panjang × lebar = 12 × 5 = 60 cm²',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '17 cm²', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '34 cm²', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '50 cm²', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '60 cm²', 'is_correct' => true],
                    ['option' => 'E', 'answer_text' => '72 cm²', 'is_correct' => false],
                ]
            ],
            // Question 7
            [
                'question_text' => 'Jika 3x = 27, maka nilai x adalah...',
                'explanation' => '3x = 27, maka x = 27 ÷ 3 = 9',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '6', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '7', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '8', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '9', 'is_correct' => true],
                    ['option' => 'E', 'answer_text' => '10', 'is_correct' => false],
                ]
            ],
            // Question 8
            [
                'question_text' => 'Hasil dari 5² + 3² adalah...',
                'explanation' => '5² = 25, 3² = 9, maka 25 + 9 = 34',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '28', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '30', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '32', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '34', 'is_correct' => true],
                    ['option' => 'E', 'answer_text' => '36', 'is_correct' => false],
                ]
            ],
            // Question 9
            [
                'question_text' => 'Urutan bilangan dari terkecil ke terbesar: 12, 8, 15, 5, 10 adalah...',
                'explanation' => 'Urutkan dari kecil ke besar: 5, 8, 10, 12, 15',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '5, 8, 10, 12, 15', 'is_correct' => true],
                    ['option' => 'B', 'answer_text' => '5, 8, 12, 10, 15', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '8, 5, 10, 12, 15', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '15, 12, 10, 8, 5', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '12, 10, 8, 5, 15', 'is_correct' => false],
                ]
            ],
            // Question 10
            [
                'question_text' => 'Hasil dari 100 - 37 + 15 adalah...',
                'explanation' => '100 - 37 = 63, kemudian 63 + 15 = 78',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '68', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '72', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '75', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '78', 'is_correct' => true],
                    ['option' => 'E', 'answer_text' => '82', 'is_correct' => false],
                ]
            ],
            // Question 11
            [
                'question_text' => 'KPK dari 4 dan 6 adalah...',
                'explanation' => 'Kelipatan 4: 4, 8, 12, 16... Kelipatan 6: 6, 12, 18... KPK = 12',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '6', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '8', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '10', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '12', 'is_correct' => true],
                    ['option' => 'E', 'answer_text' => '24', 'is_correct' => false],
                ]
            ],
            // Question 12
            [
                'question_text' => 'FPB dari 12 dan 18 adalah...',
                'explanation' => 'Faktor 12: 1,2,3,4,6,12. Faktor 18: 1,2,3,6,9,18. FPB = 6',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '2', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '3', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '6', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '9', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '12', 'is_correct' => false],
                ]
            ],
            // Question 13
            [
                'question_text' => 'Hasil dari 9 × 8 - 12 adalah...',
                'explanation' => '9 × 8 = 72, kemudian 72 - 12 = 60',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '50', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '55', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '60', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '65', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '72', 'is_correct' => false],
                ]
            ],
            // Question 14
            [
                'question_text' => 'Jika segitiga memiliki alas 10 cm dan tinggi 6 cm, luasnya adalah...',
                'explanation' => 'Luas segitiga = ½ × alas × tinggi = ½ × 10 × 6 = 30 cm²',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '16 cm²', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '20 cm²', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '30 cm²', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '40 cm²', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '60 cm²', 'is_correct' => false],
                ]
            ],
            // Question 15
            [
                'question_text' => 'Hasil dari 7 + 8 × 2 adalah...',
                'explanation' => 'Perkalian dahulu: 8 × 2 = 16, kemudian 7 + 16 = 23',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '17', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '21', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '23', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '30', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '32', 'is_correct' => false],
                ]
            ],
            // Question 16
            [
                'question_text' => '25% dari 80 adalah...',
                'explanation' => '25% = 25/100 = 0.25, maka 0.25 × 80 = 20',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '15', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '20', 'is_correct' => true],
                    ['option' => 'C', 'answer_text' => '25', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '30', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '40', 'is_correct' => false],
                ]
            ],
            // Question 17
            [
                'question_text' => 'Jika suatu bilangan dibagi 5 hasilnya 12, maka bilangan tersebut adalah...',
                'explanation' => 'x ÷ 5 = 12, maka x = 12 × 5 = 60',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '50', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '55', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '60', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '65', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '70', 'is_correct' => false],
                ]
            ],
            // Question 18
            [
                'question_text' => 'Hasil dari √144 adalah...',
                'explanation' => '√144 = 12 karena 12 × 12 = 144',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '10', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '11', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '12', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '13', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '14', 'is_correct' => false],
                ]
            ],
            // Question 19
            [
                'question_text' => 'Kelipatan 7 yang pertama adalah...',
                'explanation' => 'Kelipatan 7: 7, 14, 21, 28, 35...',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '1', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '7', 'is_correct' => true],
                    ['option' => 'C', 'answer_text' => '14', 'is_correct' => false],
                    ['option' => 'D', 'answer_text' => '21', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '0', 'is_correct' => false],
                ]
            ],
            // Question 20
            [
                'question_text' => 'Hasil dari (10 + 5) × 2 adalah...',
                'explanation' => 'Kerjakan dalam kurung dahulu: 10 + 5 = 15, kemudian 15 × 2 = 30',
                'points' => 5,
                'answers' => [
                    ['option' => 'A', 'answer_text' => '20', 'is_correct' => false],
                    ['option' => 'B', 'answer_text' => '25', 'is_correct' => false],
                    ['option' => 'C', 'answer_text' => '30', 'is_correct' => true],
                    ['option' => 'D', 'answer_text' => '35', 'is_correct' => false],
                    ['option' => 'E', 'answer_text' => '40', 'is_correct' => false],
                ]
            ],
        ];

        // Create questions and answers
        foreach ($questions as $index => $questionData) {
            $question = Question::create([
                'tryout_id' => $tryout->id,
                'question_number' => $index + 1,
                'question_text' => $questionData['question_text'],
                'question_image' => null,
                'explanation' => $questionData['explanation'],
                'points' => $questionData['points'],
            ]);

            foreach ($questionData['answers'] as $answerData) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => $answerData['option'],
                    'answer_text' => $answerData['answer_text'],
                    'answer_image' => null,
                    'is_correct' => $answerData['is_correct'],
                ]);
            }

            echo "  ✓ Question " . ($index + 1) . " created\n";
        }

        echo "\n✅ Seeder completed!\n";
        echo "📝 Tryout: {$tryout->title}\n";
        echo "🔑 Token: {$tryout->token}\n";
        echo "⏱️  Duration: {$tryout->duration_minutes} minutes\n";
        echo "📊 Total Questions: 20\n";
        echo "👤 Accessible by: Andi (SMP 7A)\n";
    }
}