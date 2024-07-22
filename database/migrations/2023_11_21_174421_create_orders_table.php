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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('role' , ['clients' , 'drivers_app']);
            $table->enum('status' , ['in_cart','in_waiting_list','confirmed','in_picking','picked_up','in_processing','processing_done','in_delivery','delivered','done']);
            $table->string('special_instructions' , 500);
            $table->string('comment' , 200);
            $table->date('pickup_date');
            $table->date('delivery_date');
            $table->dateTime('actual_pickup_start_date_time');
            $table->dateTime('actual_pickup_end_date_time');
            $table->dateTime('actual_delivery_start_date_time');
            $table->dateTime('actual_delivery_end_date_time');
            //$table->unsignedInteger('drivers_manager_id');
            $table->foreignId('drivers_manager_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            //$table->unsignedInteger('delivery_driver_assigned_to_transportation_period_id');
            $table->foreignId('delivery_driver_assigned_to_transportation_period_id')->constrained('transportation_periods')->onUpdate('cascade')->onDelete('cascade')->name('transportation_period_assigned_to_driver_id_foreign');
            //$table->unsignedInteger('pickup_driver_assigned_to_transportation_period_id');
            $table->foreignId('pickup_driver_assigned_to_transportation_period_id')->constrained('transportation_periods')->onUpdate('cascade')->onDelete('cascade')->name('transportation_period_assigned_to_driver_id_foreign');
            $table->decimal('price' , 10 , 2);
            $table->enum('type', ['easy' , 'items']);
            $table->decimal('discount_value' , 10 , 2);
            $table->enum('discount_value_type' , ['constant' , 'percentage']);
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
        Schema::dropIfExists('orders');
    }
};
