<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu apakah kolomnya udah ada
            if (!Schema::hasColumn('users', 'penalty_until')) {
                $table->timestamp('penalty_until')->nullable()->after('is_blocked');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'penalty_until')) {
                $table->dropColumn('penalty_until');
            }
        });
    }
};