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
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('month');
            $table->foreignId('shipbuilding_id');
            $table->decimal('planned_progress', 6, 3)->nullable();
            $table->decimal('actual_progres', 6, 3)->nullable();
            $table->text('report_file')->nullable();
            $table->text('summary')->nullable();
            $table->json('metadata')->nullable();

            $table->index('month');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};
