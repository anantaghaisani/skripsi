<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TryoutSeeder extends Seeder
{
    public function run(): void
    {
        $tryouts = [
            [
                'title' => 'TRYOUT UTBK 2026 #04 - SNBT',
                'code' => 'TRYOUT UTBK 2026 #04',
                'description' => 'Tryout UTBK SNBT 2026 batch 4',
                'start_date' => Carbon::parse('2025-11-13'),
                'end_date' => Carbon::parse('2025-11-20'),
                'total_questions' => 50,
                'duration_minutes' => 120,
                'status' => 'belum_dikerjakan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'TRYOUT UTBK 2026 #03 - SNBT',
                'code' => 'TRYOUT UTBK 2026 #03',
                'description' => 'Tryout UTBK SNBT 2026 batch 3',
                'start_date' => Carbon::parse('2025-11-06'),
                'end_date' => Carbon::parse('2025-11-13'),
                'total_questions' => 50,
                'duration_minutes' => 120,
                'status' => 'belum_dikerjakan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'TRYOUT UTBK 2026 #02 - SNBT',
                'code' => 'TRYOUT UTBK 2026 #02',
                'description' => 'Tryout UTBK SNBT 2026 batch 2',
                'start_date' => Carbon::parse('2025-10-30'),
                'end_date' => Carbon::parse('2025-11-06'),
                'total_questions' => 50,
                'duration_minutes' => 120,
                'status' => 'belum_dikerjakan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'TRYOUT UTBK 2026 #01 - SNBT',
                'code' => 'TRYOUT UTBK 2026 #01',
                'description' => 'Tryout UTBK SNBT 2026 batch 1',
                'start_date' => Carbon::parse('2025-10-23'),
                'end_date' => Carbon::parse('2025-10-30'),
                'total_questions' => 50,
                'duration_minutes' => 120,
                'status' => 'belum_dikerjakan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tryouts')->insert($tryouts);
    }
}
