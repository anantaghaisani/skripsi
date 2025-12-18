<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('grade_level', ['SD', 'SMP', 'SMA'])->nullable()->after('email');
            $table->integer('class_number')->nullable()->after('grade_level'); // 1-12
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['grade_level', 'class_number']);
        });
    }
};