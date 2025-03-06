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
        Schema::table('daily_equipments', function (Blueprint $table) {
            $table
                ->foreign('daily_report_id')
                ->references('id')
                ->on('daily_reports')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_equipments', function (Blueprint $table) {
            $table->dropForeign(['daily_report_id']);
        });
    }
};
