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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('shipbuilding_id');
            $table->date('date');
            $table->integer('week')->default(0);
            $table->decimal('actual_progress', 6, 3)->nullable();
            $table->foreignId('morning_weather_id')->nullable();
            $table->foreignId('morning_humidity_id')->nullable();
            $table->foreignId('midday_weather_id')->nullable();
            $table->foreignId('midday_humidity_id')->nullable();
            $table->foreignId('afternoon_weather_id')->nullable();
            $table->foreignId('afternoon_humidity_id')->nullable();
            $table->integer('temperature')->nullable();
            $table->text('summary')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
