<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\User;
use App\Models\Classes;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "\n📚 Creating sample modules...\n\n";

        // Get tentor user
        $tentor = User::where('role', 'tentor')->first();
        
        if (!$tentor) {
            echo "❌ Tentor not found! Run UserSeeder first.\n";
            return;
        }

        // Get classes by ID (ambil 3 kelas pertama)
        $classes = Classes::orderBy('id')->limit(3)->get();
        
        if ($classes->count() < 3) {
            echo "❌ Not enough classes! Need at least 3 classes.\n";
            return;
        }

        $class1 = $classes[0]->id; // SMP 7A
        $class2 = $classes[1]->id; // SMP 7B  
        $class3 = $classes[2]->id; // SMP 8A

        $modules = [
            [
                'title' => 'Matematika Dasar - Aljabar',
                'description' => 'Modul pembelajaran aljabar dasar untuk SMP kelas 7. Membahas variabel, persamaan linear, dan penerapannya.',
                'file_path' => 'modules/matematika-aljabar.pdf',
                'file_type' => 'pdf',
                'file_size' => 2457600, // 2.4 MB
                'thumbnail' => 'module-thumbnails/matematika-thumb.jpg',
                'is_active' => true,
                'created_by' => $tentor->id,
                'classes' => [$class1, $class2],
            ],
            [
                'title' => 'IPA - Sistem Pencernaan Manusia',
                'description' => 'Memahami sistem pencernaan manusia, organ-organ yang terlibat, dan proses pencernaan makanan.',
                'file_path' => 'modules/ipa-pencernaan.pdf',
                'file_type' => 'pdf',
                'file_size' => 3145728, // 3 MB
                'thumbnail' => 'module-thumbnails/ipa-thumb.jpg',
                'is_active' => true,
                'created_by' => $tentor->id,
                'classes' => [$class3],
            ],
            [
                'title' => 'Bahasa Indonesia - Teks Eksplanasi',
                'description' => 'Modul pembelajaran tentang teks eksplanasi: struktur, ciri-ciri, dan cara membuatnya.',
                'file_path' => 'modules/bahasa-indonesia-eksplanasi.pdf',
                'file_type' => 'pdf',
                'file_size' => 1835008, // 1.75 MB
                'thumbnail' => null,
                'is_active' => true,
                'created_by' => $tentor->id,
                'classes' => [$class1, $class2, $class3],
            ],
            [
                'title' => 'Bahasa Inggris - Simple Present Tense',
                'description' => 'Belajar simple present tense dengan contoh kalimat dan latihan soal.',
                'file_path' => 'modules/english-simple-present.pdf',
                'file_type' => 'pdf',
                'file_size' => 1572864, // 1.5 MB
                'thumbnail' => 'module-thumbnails/english-thumb.jpg',
                'is_active' => true,
                'created_by' => $tentor->id,
                'classes' => [$class1],
            ],
            [
                'title' => 'IPS - Keberagaman Budaya Indonesia',
                'description' => 'Mengenal keberagaman budaya, suku, dan adat istiadat di Indonesia.',
                'file_path' => 'modules/ips-budaya-indonesia.pdf',
                'file_type' => 'pdf',
                'file_size' => 4194304, // 4 MB
                'thumbnail' => 'module-thumbnails/ips-thumb.jpg',
                'is_active' => true,
                'created_by' => $tentor->id,
                'classes' => [$class1, $class2],
            ],
            [
                'title' => 'Matematika - Perbandingan dan Skala',
                'description' => 'Memahami konsep perbandingan, skala, dan aplikasinya dalam kehidupan sehari-hari.',
                'file_path' => 'modules/matematika-perbandingan.pdf',
                'file_type' => 'pdf',
                'file_size' => 2097152, // 2 MB
                'thumbnail' => null,
                'is_active' => true,
                'created_by' => $tentor->id,
                'classes' => [$class1],
            ],
            [
                'title' => 'IPA - Gerak Lurus',
                'description' => 'Modul pembelajaran tentang gerak lurus: GLB dan GLBB dengan rumus dan contoh soal.',
                'file_path' => 'modules/ipa-gerak-lurus.pdf',
                'file_type' => 'pdf',
                'file_size' => 2621440, // 2.5 MB
                'thumbnail' => 'module-thumbnails/fisika-thumb.jpg',
                'is_active' => false, // Draft
                'created_by' => $tentor->id,
                'classes' => [$class3],
            ],
            [
                'title' => 'PKN - Pancasila sebagai Dasar Negara',
                'description' => 'Memahami nilai-nilai Pancasila dan implementasinya dalam kehidupan berbangsa dan bernegara.',
                'file_path' => 'modules/pkn-pancasila.pdf',
                'file_type' => 'pdf',
                'file_size' => 1048576, // 1 MB
                'thumbnail' => null,
                'is_active' => true,
                'created_by' => $tentor->id,
                'classes' => [$class1, $class2, $class3],
            ],
        ];

        foreach ($modules as $index => $moduleData) {
            $classIds = $moduleData['classes'];
            unset($moduleData['classes']);

            $module = Module::create($moduleData);
            
            // Attach classes (akan otomatis unique karena constraint)
            $module->classes()->sync($classIds);

            echo "  ✅ Module " . ($index + 1) . ": {$module->title}\n";
            echo "     Classes: " . implode(', ', $classIds) . "\n";
        }

        echo "\n✅ " . count($modules) . " modules created successfully!\n";
        echo "👤 Created by: {$tentor->name}\n";
    }
}