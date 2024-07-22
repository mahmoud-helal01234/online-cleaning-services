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
        Schema::create('order_steps', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar' , 100);
            $table->string('title_en' , 100);
            $table->string('description_ar' , 500);
            $table->string('description_en' , 500);
            $table->string('img_path' , 100);
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
        Schema::dropIfExists('order_steps');
    }
};
