<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul modul
            $table->text('description')->nullable(); // Deskripsi
            $table->string('cover_image')->nullable(); // Cover/thumbnail
            $table->string('pdf_file'); // Path file PDF
            $table->enum('grade_level', ['SD', 'SMP', 'SMA']); // Jenjang
            $table->string('subject'); // Mata pelajaran (Matematika, IPA, dll)
            $table->integer('class_number')->nullable(); // Kelas berapa (1-12)
            $table->integer('views')->default(0); // Jumlah view
            $table->boolean('is_active')->default(true); // Status aktif/tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};