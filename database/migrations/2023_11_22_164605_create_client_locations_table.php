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
        Schema::create('client_locations', function (Blueprint $table) {
            $table->id();
            //$table->unsignedInteger('client_id');
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('lat', 10, 8);
            $table->decimal('long', 10, 8);
            $table->string('phone_number' , 20);
            $table->string('telephone' , 20);

            $table->enum('location_type', ['apartment', 'house', 'office', 'other']);
            $table->string('street', 50);
            $table->string('building', 10);
            $table->string('floor', 10);
            $table->string('apartment', 10);

            $table->string('additional_instructions', 200);
            $table->string('detailed_address', 200);


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
        Schema::dropIfExists('client_locations');
    }
};
