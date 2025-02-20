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
        Schema::table('shipbuildings', function (Blueprint $table) {
            $table
                ->foreign('ship_type_id')
                ->references('id')
                ->on('ship_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('shipyard_id')
                ->references('id')
                ->on('shipyards')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipbuildings', function (Blueprint $table) {
            $table->dropForeign(['ship_type_id']);
            $table->dropForeign(['shipyard_id']);
        });
    }
};
