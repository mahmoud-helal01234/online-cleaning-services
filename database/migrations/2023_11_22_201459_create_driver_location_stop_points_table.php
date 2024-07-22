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
        Schema::create('driver_location_stop_points', function (Blueprint $table) {

            //$table->unsignedInteger('driver_location_id')->primary();
            $table->foreignId('driver_location_id')->constrained('driver_locations')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('driver_location_stop_points');
    }
};
