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
        Schema::create('governorates', function (Blueprint $table) {

            $table->id();

            $table->string('name_ar' , 50);
            $table->string('name_en' , 50);

            // $table->unsignedInteger('country_id');
            $table->foreignId('country_id')->constrained('countries')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('governorates');
    }
};
