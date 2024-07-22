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
        Schema::create('orders_have_base_orders_rates', function (Blueprint $table) {
            $table->id();
            //$table->unsignedInteger('order_id');
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
            //$table->unsignedInteger('base_order_rate_id');
            $table->foreignId('base_order_rate_id')->constrained('base_orders_rates')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('value' ,['1','2','3','4','5']);
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
        Schema::dropIfExists('orders_have_base_orders_rates');
    }
};
