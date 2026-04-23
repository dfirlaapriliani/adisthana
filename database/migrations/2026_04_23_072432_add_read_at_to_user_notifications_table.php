<?php
// database/migrations/xxxx_xx_xx_add_read_at_to_user_notifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('user_notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('is_read');
            }
            if (!Schema::hasColumn('user_notifications', 'data')) {
                $table->json('data')->nullable()->after('type');
            }
            if (!Schema::hasColumn('user_notifications', 'url')) {
                $table->string('url')->nullable()->after('message');
            }
            if (!Schema::hasColumn('user_notifications', 'icon')) {
                $table->string('icon')->nullable()->after('type');
            }
        });
    }

    public function down()
    {
        Schema::table('user_notifications', function (Blueprint $table) {
            $table->dropColumn(['read_at', 'data', 'url', 'icon']);
        });
    }
};