<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipbuilding_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('shipbuilding_id');
            $table->integer('level')->default(1);
            $table->integer('sort_order')->default(1);
            $table->foreignId('parent_task_id')->nullable();
            $table
                ->enum('item_type', ['work-item', 'category'])
                ->default('work-item');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('weight', 10, 3)->default(0);
            $table
                ->enum('enable_sub_progress', ['work-item', 'category'])
                ->default('work-item');
            $table->bigInteger('lock_element_set')->default(0);
            $table->json('progress_options')->nullable();
            $table->decimal('progress', 6, 3)->default(0);
            $table->decimal('target', 6, 3)->default(0);
            $table->decimal('deviation', 6, 3)->default(0);
            $table->decimal('score', 10, 3)->default(10);
            $table->integer('sub_tasks_count')->default(0);
            $table->decimal('sub_tasks_weight_sum', 10, 3)->default(0);
            $table->decimal('sub_tasks_score_sum', 10, 3)->default(0);
            $table->decimal('on_group_progress', 6, 3)->default(0);
            $table->decimal('on_project_weight', 10, 3)->default(0);
            $table->decimal('on_project_progress', 6, 3)->default(0);
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipbuilding_tasks');
    }
};
