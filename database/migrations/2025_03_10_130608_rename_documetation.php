<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('daily_documetations', 'daily_documentations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('daily_documentations', 'daily_documetations');
    }
};
