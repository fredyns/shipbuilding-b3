<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shipbuilding_tasks', function (Blueprint $table) {
            $table->renameColumn('lock_element_set', 'worksheet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipbuilding_tasks', function (Blueprint $table) {
            $table->renameColumn('worksheet_id', 'lock_element_set');
        });
    }
};
