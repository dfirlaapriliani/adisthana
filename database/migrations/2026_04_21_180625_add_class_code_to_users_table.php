<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus dulu identifier kalau mau diganti total
            if (Schema::hasColumn('users', 'identifier')) {
                $table->dropColumn('identifier');
            }
            $table->string('class_code')->nullable()->unique()->after('email');
            $table->string('class_name')->nullable()->after('class_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['class_code', 'class_name']);
            $table->string('identifier')->nullable()->unique();
        });
    }
};