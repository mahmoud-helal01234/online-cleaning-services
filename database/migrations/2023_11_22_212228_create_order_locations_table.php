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
        Schema::create('order_locations', function (Blueprint $table) {
            $table->id();
           // $table->unsignedInteger('order_id');
           $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
           //$table->unsignedInteger('driver_id');
           $table->foreignId('driver_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
           $table->decimal('lat', 10, 8);
            $table->decimal('long', 10, 8);
            $table->enum('status' ,['in_delivery','in_pickup']);
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
        Schema::dropIfExists('order_locations');
    }
};
