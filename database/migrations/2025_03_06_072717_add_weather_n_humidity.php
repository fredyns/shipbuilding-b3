<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('weathers')->insert([
            ['name' => 'Hujan'],
            ['name' => 'Mendung'],
            ['name' => 'Berawan'],
            ['name' => 'Cerah'],
        ]);
        DB::table('humidities')->insert([
            ['name' => 'Lembab'],
            ['name' => 'Sedang'],
            ['name' => 'Kering'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
