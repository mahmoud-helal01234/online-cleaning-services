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
        Schema::create('offers_page_content', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar' , 200);
            $table->string('title_en' , 200);
            $table->string('second_title_ar' , 150);
            $table->string('second_title_en' , 150);
            $table->string('logo_path' , 100);
            $table->string('img_path' , 100);
            $table->string('google_play_link' , 100);
            $table->string('app_store_link' , 100);
            $table->string('content_ar' , 500);
            $table->string('content_en' , 500);
            $table->boolean('active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers_page_content');
    }
};
