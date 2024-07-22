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
        Schema::create('home_page_content', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar' , 200);
            $table->string('title_en' , 200);
            $table->string('content_ar' , 500);
            $table->string('content_en' , 500);
            $table->string('button_text_ar' , 25);
            $table->string('button_text_en' , 25);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_page_content');
    }
};
