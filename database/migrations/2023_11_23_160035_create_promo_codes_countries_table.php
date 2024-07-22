<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes_countries', function (Blueprint $table) {
            $table->id();
            //$table->unsignedInteger('promo_code_id');
            $table->foreignId('promo_code_id')->constrained('promo_codes')->onUpdate('cascade')->onDelete('cascade');
           // $table->unsignedInteger('country_id');
           $table->foreignId('country_id')->constrained('countries')->onUpdate('cascade')->onDelete('cascade');
           $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_codes_countries');
    }
};
