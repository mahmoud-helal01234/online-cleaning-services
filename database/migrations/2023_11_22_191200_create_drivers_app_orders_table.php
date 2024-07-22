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
        Schema::create('drivers_app_orders', function (Blueprint $table) {

            //$table->unsignedInteger('order_id')->primary();
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade')->primary();
            // $table->unsignedInteger('user_id');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('delivery_type', ['normal' , 'fast']);
            // $table->unsignedInteger('drivers_app_client_id');
            $table->foreignId('drivers_app_client_id')->constrained('drivers_app_clients')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('discount_value' , 10 , 2);
            $table->enum('discount_value_type', ['constant' , 'percentage']);

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
        Schema::dropIfExists('drivers_app_orders');
    }
};
