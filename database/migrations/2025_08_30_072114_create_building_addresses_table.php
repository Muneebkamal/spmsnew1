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
        Schema::create('building_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('building')->nullable();
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->string('address_chinese')->nullable();
            $table->string('usage')->nullable();
            $table->string('year_of_completion')->nullable();
            $table->string('property_type')->nullable();
            $table->string('title')->nullable();
            $table->string('management_company')->nullable();
            $table->string('developers')->nullable();
            $table->string('transportation')->nullable();
            $table->string('floor')->nullable();
            $table->string('floor_area')->nullable();
            $table->string('height')->nullable();
            $table->string('air_con_system')->nullable();
            $table->string('lifts')->nullable();
            $table->string('parking')->nullable();
            $table->string('carpark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_addresses');
    }
};
