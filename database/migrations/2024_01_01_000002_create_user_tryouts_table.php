<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_tryouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tryout_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['belum_dikerjakan', 'sedang_dikerjakan', 'sudah_dikerjakan'])->default('belum_dikerjakan');
            $table->integer('score')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
            
            // Pastikan user tidak bisa mengambil tryout yang sama 2x
            $table->unique(['user_id', 'tryout_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tryouts');
    }
};
