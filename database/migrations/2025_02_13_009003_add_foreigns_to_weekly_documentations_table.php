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
        Schema::table('weekly_documentations', function (Blueprint $table) {
            $table
                ->foreign('weekly_report_id')
                ->references('id')
                ->on('weekly_reports')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weekly_documentations', function (Blueprint $table) {
            $table->dropForeign(['weekly_report_id']);
        });
    }
};
