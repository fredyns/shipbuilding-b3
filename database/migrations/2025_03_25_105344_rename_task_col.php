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
            $table->renameColumn('sub_tasks_count', 'subtasks_count');
            $table->renameColumn('sub_tasks_weight_sum', 'subtasks_weight_sum');
            $table->renameColumn('sub_tasks_score_sum', 'subtasks_score_sum');
            $table->renameColumn('on_group_progress', 'on_peer_progress');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipbuilding_tasks', function (Blueprint $table) {
            $table->renameColumn('subtasks_count', 'sub_tasks_count');
            $table->renameColumn('subtasks_weight_sum', 'sub_tasks_weight_sum');
            $table->renameColumn('subtasks_score_sum', 'sub_tasks_score_sum');
            $table->renameColumn('on_peer_progress', 'on_group_progress');
        });
    }
};
