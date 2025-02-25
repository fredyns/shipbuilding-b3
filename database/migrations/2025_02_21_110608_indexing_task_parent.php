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
            $table->index(['parent_task_id', 'sort_order'], 'child_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipbuilding_tasks', function (Blueprint $table) {
            $table->dropIndex('child_order');
        });
    }
};
