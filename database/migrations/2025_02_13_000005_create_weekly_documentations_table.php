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
        Schema::create('weekly_documentations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('weekly_report_id');
            $table->text('file');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->json('metadata')->nullable();
            $table->text('thumbnail')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_documentations');
    }
};
