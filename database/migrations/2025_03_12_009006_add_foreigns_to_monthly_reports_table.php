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
        Schema::table('monthly_reports', function (Blueprint $table) {
            $table
                ->foreign('shipbuilding_id')
                ->references('id')
                ->on('shipbuildings')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_reports', function (Blueprint $table) {
            $table->dropForeign(['shipbuilding_id']);
        });
    }
};
