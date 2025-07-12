<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('postal_code', 8)->unique();
            $table->string('street', 255);
            $table->string('complement', 255)->nullable();
            $table->string('neighborhood', 100);
            $table->string('city', 100);
            $table->string('unit', 100);
            $table->string('country', 100);
            $table->string('state_abbreviation', 2);
            $table->string('state', 100);
            $table->string('ibge_code', 7)->nullable();
            $table->string('gia_code', 10)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('area_code', 3)->nullable();
            $table->string('siafi_code', 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
