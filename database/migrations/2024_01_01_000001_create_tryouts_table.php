<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique(); // TRYOUT UTBK 2026 #04
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_questions')->default(50);
            $table->integer('duration_minutes')->default(120); // durasi dalam menit
            $table->enum('status', ['belum_dikerjakan', 'sudah_dikerjakan'])->default('belum_dikerjakan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryouts');
    }
};
