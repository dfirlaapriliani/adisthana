<?php
// database/migrations/xxxx_xx_xx_add_book_id_to_user_notifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('user_notifications', 'book_id')) {
                $table->foreignId('book_id')->nullable()->after('booking_id')->constrained('books')->nullOnDelete();
            }
        });
    }

    public function down()
    {
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropColumn('book_id');
        });
    }
};