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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar' , 50);
            $table->string('name_en' , 50);
            $table->string('img_path');
            $table->boolean('have_sub_categories');
            // forign key
            // $table->unsignedInteger('parent_id')->nullable();
            $table->foreignId('parent_id')->constrained('categories')->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('active');
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
        Schema::dropIfExists('categories');
    }
};
