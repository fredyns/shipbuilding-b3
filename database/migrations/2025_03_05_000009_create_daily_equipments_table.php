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
        Schema::create('daily_equipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('daily_report_id');
            $table->string('name');
            $table->integer('quantity')->default(1);
            $table->string('remark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_equipments');
    }
};
