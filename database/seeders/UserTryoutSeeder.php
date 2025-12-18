<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Tryout;
use Carbon\Carbon;

class UserTryoutSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user pertama (Test User)
        $user = User::first();
        
        if (!$user) {
            echo "User tidak ditemukan! Jalankan DatabaseSeeder terlebih dahulu.\n";
            return;
        }

        // Ambil tryout yang sudah dikerjakan
        $completedTryouts = Tryout::where('status', 'sudah_dikerjakan')->get();

        foreach ($completedTryouts as $tryout) {
            // Insert ke user_tryouts
            DB::table('user_tryouts')->insert([
                'user_id' => $user->id,
                'tryout_id' => $tryout->id,
                'status' => 'sudah_dikerjakan',
                'score' => rand(60, 95), // Random score antara 60-95
                'started_at' => Carbon::parse($tryout->start_date)->addHours(2),
                'finished_at' => Carbon::parse($tryout->start_date)->addHours(4),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "User tryout data berhasil dibuat!\n";
    }
}