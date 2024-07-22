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
        Schema::create('drivers_app_clients', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('user_id');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name' , 100);
            $table->string('address' , 100);
            $table->string('phone' , 20);
            $table->decimal('lat' , 10 , 8);
            $table->decimal('long' , 10 , 8);
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
        Schema::dropIfExists('drivers_app_clients');
    }
};
