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
        Schema::create('order_location_stop_points', function (Blueprint $table) {
          //  $table->unsignedInteger('order_location_id');
          $table->foreignId('order_location_id')->constrained('order_locations')->onUpdate('cascade')->onDelete('cascade');
          $table->timestamp('to_at');
            $table->enum('reason', ['traffic', 'not_traffic']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_location_stop_points');
    }
};
