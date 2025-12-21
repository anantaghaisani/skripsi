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
        Schema::table('tryouts', function (Blueprint $table) {
            // Check if token doesn't exist before adding
            if (!Schema::hasColumn('tryouts', 'token')) {
                $table->string('token', 6)->unique()->after('code');
            }
            
            // Check if created_by doesn't exist before adding
            if (!Schema::hasColumn('tryouts', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tryouts', function (Blueprint $table) {
            if (Schema::hasColumn('tryouts', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            
            if (Schema::hasColumn('tryouts', 'token')) {
                $table->dropColumn('token');
            }
        });
    }
};