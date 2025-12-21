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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->enum('option', ['A', 'B', 'C', 'D', 'E']); // Pilihan A-E
            $table->text('answer_text'); // Teks jawaban
            $table->string('answer_image')->nullable(); // Gambar jawaban (optional)
            $table->boolean('is_correct')->default(false); // Apakah ini kunci jawaban
            $table->timestamps();
            
            $table->index(['question_id', 'option']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};