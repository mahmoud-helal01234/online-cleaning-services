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
        Schema::create('transportation_periods_assigned_to_drivers', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('driver_id');
            $table->foreignId('driver_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('transportation_period_id');
            $table->foreignId('transportation_period_id')->constrained('transportation_periods')->onUpdate('cascade')->onDelete('cascade')->name('transportation_period_id_foreign');
            $table->integer('capacity');
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
        Schema::dropIfExists('transportation_periods');
    }
};
