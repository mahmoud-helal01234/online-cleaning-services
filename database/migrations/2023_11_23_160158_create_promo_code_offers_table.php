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
        Schema::create('promo_code_offers', function (Blueprint $table) {
            $table->id();
            //$table->unsignedInteger('promo_code_id');
            $table->foreignId('promo_code_id')->constrained('promo_codes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('img_path', 100);
            $table->boolean('active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_code_offers');
    }
};
