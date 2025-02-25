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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('shipbuilding_id');
            $table->integer('week');
            $table->date('month')->nullable();
            $table->decimal('planned_progress', 6, 3)->nullable();
            $table->decimal('actual_progress', 6, 3)->nullable();
            $table->text('summary')->nullable();
            $table->text('report_file')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
