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
        Schema::table('daily_reports', function (Blueprint $table) {
            $table
                ->foreign('shipbuilding_id')
                ->references('id')
                ->on('shipbuildings')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('morning_weather_id')
                ->references('id')
                ->on('weathers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('morning_humidity_id')
                ->references('id')
                ->on('humidities')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('midday_weather_id')
                ->references('id')
                ->on('weathers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('midday_humidity_id')
                ->references('id')
                ->on('humidities')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('afternoon_weather_id')
                ->references('id')
                ->on('weathers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('afternoon_humidity_id')
                ->references('id')
                ->on('humidities')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            $table->dropForeign(['shipbuilding_id']);
            $table->dropForeign(['morning_weather_id']);
            $table->dropForeign(['morning_humidity_id']);
            $table->dropForeign(['midday_weather_id']);
            $table->dropForeign(['midday_humidity_id']);
            $table->dropForeign(['afternoon_weather_id']);
            $table->dropForeign(['afternoon_humidity_id']);
        });
    }
};
