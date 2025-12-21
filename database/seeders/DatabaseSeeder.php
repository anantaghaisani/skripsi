<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ClassSeeder::class,      // Buat kelas dulu
            UserSeeder::class,        // Baru buat users (karena user butuh class_id)
            TryoutSeeder::class,      // Buat tryout
            UserTryoutSeeder::class,  // Buat relasi user-tryout
            ModuleSeeder::class,      // Buat modul
        ]);
    }
}