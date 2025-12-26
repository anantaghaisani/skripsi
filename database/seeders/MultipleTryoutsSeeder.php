<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tryout;
use App\Models\Question;
use App\Models\Answer;

class MultipleTryoutsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tryouts = [
            // Tryout 1: Matematika
            [
                'title' => 'Tryout Matematika Dasar SMP',
                'code' => 'TO-MAT-001',
                'token' => 'MAT001',
                'description' => 'Tryout matematika dasar untuk SMP kelas 7',
                'duration_minutes' => 30,
                'questions' => $this->getMathQuestions(),
            ],
            // Tryout 2: IPA
            [
                'title' => 'Tryout IPA Terpadu',
                'code' => 'TO-IPA-001',
                'token' => 'IPA001',
                'description' => 'Tryout IPA Fisika dan Biologi untuk SMP',
                'duration_minutes' => 25,
                'questions' => $this->getScienceQuestions(),
            ],
            // Tryout 3: Bahasa Indonesia
            [
                'title' => 'Tryout Bahasa Indonesia',
                'code' => 'TO-BIN-001',
                'token' => 'BIN001',
                'description' => 'Tryout bahasa Indonesia dan sastra',
                'duration_minutes' => 20,
                'questions' => $this->getIndonesianQuestions(),
            ],
            // Tryout 4: Bahasa Inggris
            [
                'title' => 'Tryout Bahasa Inggris',
                'code' => 'TO-ENG-001',
                'token' => 'ENG001',
                'description' => 'Tryout bahasa Inggris dasar',
                'duration_minutes' => 20,
                'questions' => $this->getEnglishQuestions(),
            ],
            // Tryout 5: IPS
            [
                'title' => 'Tryout IPS Terpadu',
                'code' => 'TO-IPS-001',
                'token' => 'IPS001',
                'description' => 'Tryout IPS Geografi dan Sejarah',
                'duration_minutes' => 25,
                'questions' => $this->getSocialQuestions(),
            ],
        ];

        foreach ($tryouts as $tryoutData) {
            echo "\n📝 Creating: {$tryoutData['title']}\n";
            
            // Check if tryout exists
            $tryout = Tryout::where('code', $tryoutData['code'])->first();
            
            if ($tryout) {
                echo "  ⚠️  Tryout already exists, clearing questions...\n";
                $tryout->questions()->delete();
            } else {
                $tryout = Tryout::create([
                    'title' => $tryoutData['title'],
                    'code' => $tryoutData['code'],
                    'token' => $tryoutData['token'],
                    'description' => $tryoutData['description'],
                    'start_date' => now()->subDays(1),
                    'end_date' => now()->addDays(30),
                    'total_questions' => count($tryoutData['questions']),
                    'duration_minutes' => $tryoutData['duration_minutes'],
                    'is_active' => true,
                    'created_by' => 1,
                ]);

                // Attach to SMP 7A (class_id = 1)
                $tryout->classes()->attach([1]);
                echo "  ✅ Tryout created\n";
            }

            // Create questions
            foreach ($tryoutData['questions'] as $index => $questionData) {
                $question = Question::create([
                    'tryout_id' => $tryout->id,
                    'question_number' => $index + 1,
                    'question_text' => $questionData['question_text'],
                    'question_image' => null,
                    'explanation' => $questionData['explanation'],
                    'points' => 5,
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

                echo "  ✓ Question " . ($index + 1) . "\n";
            }

            echo "  🔑 Token: {$tryoutData['token']}\n";
        }

        echo "\n✅ All tryouts created successfully!\n";
        echo "👤 Accessible by: Andi (SMP 7A)\n\n";
        echo "📋 Summary:\n";
        echo "1. Matematika (MAT001) - 30 min\n";
        echo "2. IPA (IPA001) - 25 min\n";
        echo "3. Bahasa Indonesia (BIN001) - 20 min\n";
        echo "4. Bahasa Inggris (ENG001) - 20 min\n";
        echo "5. IPS (IPS001) - 25 min\n";
    }

    private function getMathQuestions()
    {
        return [
            ['question_text' => 'Hasil dari 25 + 17 - 9 adalah...', 'explanation' => '25 + 17 = 42, kemudian 42 - 9 = 33', 'answers' => [
                ['option' => 'A', 'answer_text' => '31', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => '32', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => '33', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => '34', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => '35', 'is_correct' => false],
            ]],
            ['question_text' => 'Hasil dari 8 × 9 adalah...', 'explanation' => '8 × 9 = 72', 'answers' => [
                ['option' => 'A', 'answer_text' => '63', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => '72', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => '81', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => '90', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => '99', 'is_correct' => false],
            ]],
            ['question_text' => 'Keliling persegi dengan sisi 12 cm adalah...', 'explanation' => 'Keliling = 4 × sisi = 4 × 12 = 48 cm', 'answers' => [
                ['option' => 'A', 'answer_text' => '36 cm', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => '44 cm', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => '48 cm', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => '52 cm', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => '60 cm', 'is_correct' => false],
            ]],
            ['question_text' => 'Hasil dari 72 ÷ 8 adalah...', 'explanation' => '72 ÷ 8 = 9', 'answers' => [
                ['option' => 'A', 'answer_text' => '7', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => '8', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => '9', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => '10', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => '11', 'is_correct' => false],
            ]],
            ['question_text' => '50% dari 60 adalah...', 'explanation' => '50% = 0.5, maka 0.5 × 60 = 30', 'answers' => [
                ['option' => 'A', 'answer_text' => '20', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => '25', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => '30', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => '35', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => '40', 'is_correct' => false],
            ]],
        ];
    }

    private function getScienceQuestions()
    {
        return [
            ['question_text' => 'Planet terdekat dengan Matahari adalah...', 'explanation' => 'Merkurius adalah planet terdekat dengan Matahari', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Venus', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Bumi', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Merkurius', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Mars', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Jupiter', 'is_correct' => false],
            ]],
            ['question_text' => 'Proses perubahan air menjadi uap disebut...', 'explanation' => 'Evaporasi adalah proses penguapan air', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Kondensasi', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Evaporasi', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'Presipitasi', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Sublimasi', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Kristalisasi', 'is_correct' => false],
            ]],
            ['question_text' => 'Organ yang berfungsi memompa darah adalah...', 'explanation' => 'Jantung berfungsi memompa darah ke seluruh tubuh', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Paru-paru', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Hati', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Jantung', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Ginjal', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Lambung', 'is_correct' => false],
            ]],
            ['question_text' => 'Satuan kecepatan dalam SI adalah...', 'explanation' => 'Meter per sekon (m/s) adalah satuan kecepatan dalam SI', 'answers' => [
                ['option' => 'A', 'answer_text' => 'km/jam', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'm/s', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'cm/s', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'mil/jam', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'knot', 'is_correct' => false],
            ]],
            ['question_text' => 'Fotosintesis terjadi pada bagian tumbuhan yaitu...', 'explanation' => 'Fotosintesis terjadi di daun dengan bantuan klorofil', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Akar', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Batang', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Daun', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Bunga', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Buah', 'is_correct' => false],
            ]],
        ];
    }

    private function getIndonesianQuestions()
    {
        return [
            ['question_text' => 'Kata baku dari "apotek" adalah...', 'explanation' => 'Bentuk baku dari apotek adalah apotik', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Apotik', 'is_correct' => true],
                ['option' => 'B', 'answer_text' => 'Apothek', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Apotek', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Apotiek', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Aphotik', 'is_correct' => false],
            ]],
            ['question_text' => 'Antonim dari kata "senang" adalah...', 'explanation' => 'Sedih adalah lawan kata (antonim) dari senang', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Gembira', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Bahagia', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Sedih', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Suka', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Riang', 'is_correct' => false],
            ]],
            ['question_text' => 'Kalimat yang menggunakan kata tanya disebut kalimat...', 'explanation' => 'Kalimat interogatif adalah kalimat tanya', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Deklaratif', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Imperatif', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Interogatif', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Eksklamatif', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Persuasif', 'is_correct' => false],
            ]],
            ['question_text' => 'Imbuhan "ber-" pada kata "berjalan" termasuk...', 'explanation' => 'Imbuhan ber- adalah awalan (prefiks)', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Awalan', 'is_correct' => true],
                ['option' => 'B', 'answer_text' => 'Akhiran', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Sisipan', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Konfiks', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Simulfiks', 'is_correct' => false],
            ]],
            ['question_text' => 'Sinonim dari kata "pintar" adalah...', 'explanation' => 'Cerdas adalah persamaan kata (sinonim) dari pintar', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Bodoh', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Cerdas', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'Malas', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Rajin', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Giat', 'is_correct' => false],
            ]],
        ];
    }

    private function getEnglishQuestions()
    {
        return [
            ['question_text' => 'What is the opposite of "big"?', 'explanation' => 'Small is the opposite of big', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Large', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Small', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'Huge', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Tall', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Wide', 'is_correct' => false],
            ]],
            ['question_text' => 'She ... to school every day.', 'explanation' => 'Goes is correct because "she" is third person singular', 'answers' => [
                ['option' => 'A', 'answer_text' => 'go', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'goes', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'going', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'gone', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'went', 'is_correct' => false],
            ]],
            ['question_text' => 'What is the past tense of "eat"?', 'explanation' => 'Ate is the past tense of eat', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Eated', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Ate', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'Eating', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Eaten', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Eats', 'is_correct' => false],
            ]],
            ['question_text' => 'A place where we can borrow books is called...', 'explanation' => 'Library is a place to borrow books', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Museum', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Library', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'Bookstore', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'School', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Office', 'is_correct' => false],
            ]],
            ['question_text' => 'How many days are there in a week?', 'explanation' => 'There are 7 days in a week', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Five', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Six', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Seven', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Eight', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Ten', 'is_correct' => false],
            ]],
        ];
    }

    private function getSocialQuestions()
    {
        return [
            ['question_text' => 'Ibu kota Indonesia adalah...', 'explanation' => 'Jakarta adalah ibu kota negara Indonesia', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Bandung', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Surabaya', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Jakarta', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Medan', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Semarang', 'is_correct' => false],
            ]],
            ['question_text' => 'Proklamasi kemerdekaan Indonesia dibacakan tanggal...', 'explanation' => 'Proklamasi kemerdekaan dibacakan 17 Agustus 1945', 'answers' => [
                ['option' => 'A', 'answer_text' => '17 Agustus 1945', 'is_correct' => true],
                ['option' => 'B', 'answer_text' => '1 Juni 1945', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => '20 Mei 1908', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => '28 Oktober 1928', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => '1 Maret 1945', 'is_correct' => false],
            ]],
            ['question_text' => 'Benua terbesar di dunia adalah...', 'explanation' => 'Asia adalah benua terbesar di dunia', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Afrika', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Asia', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'Amerika', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Eropa', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Australia', 'is_correct' => false],
            ]],
            ['question_text' => 'Negara dengan julukan Negeri Sakura adalah...', 'explanation' => 'Jepang dijuluki Negeri Sakura', 'answers' => [
                ['option' => 'A', 'answer_text' => 'China', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Korea', 'is_correct' => false],
                ['option' => 'C', 'answer_text' => 'Jepang', 'is_correct' => true],
                ['option' => 'D', 'answer_text' => 'Thailand', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Vietnam', 'is_correct' => false],
            ]],
            ['question_text' => 'Pahlawan yang dijuluki "Bapak Koperasi Indonesia" adalah...', 'explanation' => 'Mohammad Hatta dijuluki Bapak Koperasi Indonesia', 'answers' => [
                ['option' => 'A', 'answer_text' => 'Soekarno', 'is_correct' => false],
                ['option' => 'B', 'answer_text' => 'Mohammad Hatta', 'is_correct' => true],
                ['option' => 'C', 'answer_text' => 'Ki Hajar Dewantara', 'is_correct' => false],
                ['option' => 'D', 'answer_text' => 'Kartini', 'is_correct' => false],
                ['option' => 'E', 'answer_text' => 'Diponegoro', 'is_correct' => false],
            ]],
        ];
    }
}