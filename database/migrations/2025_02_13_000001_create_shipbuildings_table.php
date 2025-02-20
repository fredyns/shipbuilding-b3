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
        Schema::create('shipbuildings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('progress', 6, 3)->default(0);
            $table->foreignId('ship_type_id')->nullable();
            $table->foreignId('shipyard_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('tasks_level_deep')->default(0);
            $table->integer('tasks_count')->default(0);
            $table->decimal('tasks_weight_sum', 10, 3)->default(0);
            $table->decimal('tasks_score_sum', 10, 3)->default(0);
            $table->text('cover_image')->nullable();
            $table->decimal('target', 6, 3)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipbuildings');
    }
};
