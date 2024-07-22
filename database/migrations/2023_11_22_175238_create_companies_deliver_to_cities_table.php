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
        Schema::create('companies_deliver_to_cities', function (Blueprint $table) {
            $table->id();
           // $table->unsignedInteger('company_id');
           $table->foreignId('company_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            //$table->unsignedInteger('city_id');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('companies_deliver_to_cities');
    }
};
