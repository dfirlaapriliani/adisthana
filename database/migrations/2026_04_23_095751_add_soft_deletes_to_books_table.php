<?php
// database/migrations/2026_04_23_add_soft_deletes_to_books_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};