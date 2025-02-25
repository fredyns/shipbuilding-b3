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
            $table
                ->foreign('shipbuilding_id')
                ->references('id')
                ->on('shipbuildings')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('parent_task_id')
                ->references('id')
                ->on('shipbuilding_tasks')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipbuilding_tasks', function (Blueprint $table) {
            $table->dropForeign(['shipbuilding_id']);
            $table->dropForeign(['parent_task_id']);
        });
    }
};
