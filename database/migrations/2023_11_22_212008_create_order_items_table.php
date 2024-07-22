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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            //$table->unsignedInteger('order_id');
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
           // $table->unsignedInteger('product_options_id');
            $table->foreignId('product_options_id')->constrained('product_options')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('quantity', 10);
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
        Schema::dropIfExists('order_items');
    }
};
