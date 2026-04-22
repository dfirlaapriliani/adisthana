<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('facility_schedules');
    }

    public function down(): void
    {
        // No need to restore
    }
};