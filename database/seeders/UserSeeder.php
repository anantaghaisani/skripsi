<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Classes;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin HMC',
            'email' => 'admin@hmc.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Tentor 1
        User::create([
            'name' => 'Pak Budi',
            'email' => 'tentor1@hmc.com',
            'password' => Hash::make('password'),
            'role' => 'tentor',
        ]);

        // Tentor 2
        User::create([
            'name' => 'Bu Ani',
            'email' => 'tentor2@hmc.com',
            'password' => Hash::make('password'),
            'role' => 'tentor',
        ]);

        // Get some classes for students
        $smp7a = Classes::where('grade_level', 'SMP')->where('class_number', 7)->where('name', 'A')->first();
        $smp7b = Classes::where('grade_level', 'SMP')->where('class_number', 7)->where('name', 'B')->first();
        $sma10a = Classes::where('grade_level', 'SMA')->where('class_number', 10)->where('name', 'A')->first();

        // Students for SMP 7A
        if ($smp7a) {
            User::create([
                'name' => 'Andi Pratama',
                'email' => 'andi@student.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'grade_level' => 'SMP',
                'class_number' => 7,
                'class_id' => $smp7a->id,
            ]);

            User::create([
                'name' => 'Budi Santoso',
                'email' => 'budi@student.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'grade_level' => 'SMP',
                'class_number' => 7,
                'class_id' => $smp7a->id,
            ]);
        }

        // Students for SMP 7B
        if ($smp7b) {
            User::create([
                'name' => 'Citra Dewi',
                'email' => 'citra@student.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'grade_level' => 'SMP',
                'class_number' => 7,
                'class_id' => $smp7b->id,
            ]);

            User::create([
                'name' => 'Dina Permata',
                'email' => 'dina@student.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'grade_level' => 'SMP',
                'class_number' => 7,
                'class_id' => $smp7b->id,
            ]);
        }

        // Students for SMA 10A
        if ($sma10a) {
            User::create([
                'name' => 'Eka Putra',
                'email' => 'eka@student.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'grade_level' => 'SMA',
                'class_number' => 10,
                'class_id' => $sma10a->id,
            ]);
        }
    }
}