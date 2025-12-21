<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tryout_id')->constrained('tryouts')->onDelete('cascade');
            $table->integer('question_number'); // Nomor soal (1, 2, 3, ...)
            $table->text('question_text'); // Teks soal
            $table->string('question_image')->nullable(); // Gambar soal (optional)
            $table->text('explanation')->nullable(); // Pembahasan
            $table->integer('points')->default(1); // Bobot nilai per soal
            $table->timestamps();
            
            $table->index(['tryout_id', 'question_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};