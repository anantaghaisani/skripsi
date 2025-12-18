<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user dummy untuk testing
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Jalankan seeder tryout
        $this->call([
            TryoutSeeder::class,
            UserTryoutSeeder::class, // Seeder untuk relasi user-tryout
        ]);
    }
}