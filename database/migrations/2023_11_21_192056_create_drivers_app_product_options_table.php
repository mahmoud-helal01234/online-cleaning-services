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
        Schema::create('drivers_app_product_options', function (Blueprint $table) {

            $table->id();
            $table->string('name' , 150);
            $table->double('price');
            //$table->unsignedInteger('drivers_app_product_id');
            $table->foreignId('drivers_app_product_id')->constrained('drivers_app_products')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('drivers_app_product_options');
    }
};
