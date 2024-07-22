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
        Schema::create('promo_codes_companies', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('promo_code_id');
            $table->foreignId('promo_code_id')->constrained('promo_codes')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('company_id');
            $table->foreignId('order_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('promo_codes_companies');
    }
};
