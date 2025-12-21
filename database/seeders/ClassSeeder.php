<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            // SMP Classes
            ['name' => 'A', 'grade_level' => 'SMP', 'class_number' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B', 'grade_level' => 'SMP', 'class_number' => 7, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A', 'grade_level' => 'SMP', 'class_number' => 8, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B', 'grade_level' => 'SMP', 'class_number' => 8, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A', 'grade_level' => 'SMP', 'class_number' => 9, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B', 'grade_level' => 'SMP', 'class_number' => 9, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],

            // SMA Classes
            ['name' => 'A', 'grade_level' => 'SMA', 'class_number' => 10, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B', 'grade_level' => 'SMA', 'class_number' => 10, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A', 'grade_level' => 'SMA', 'class_number' => 11, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B', 'grade_level' => 'SMA', 'class_number' => 11, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'A', 'grade_level' => 'SMA', 'class_number' => 12, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'B', 'grade_level' => 'SMA', 'class_number' => 12, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('classes')->insert($classes);
    }
}