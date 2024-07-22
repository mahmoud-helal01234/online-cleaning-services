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
        Schema::create('nav_bar_footer_content', function (Blueprint $table) {
            $table->id();
            $table->string('whatsapp_number' , 20);
            $table->string('phone_number' , 20);
            $table->string('facebook_link' , 100);
            $table->string('instagram_link' , 100);
            $table->string('twitter_link' , 100);
            $table->string('footer_title_ar' , 100);
            $table->string('footer_title_en' , 100);
            $table->string('footer_content_ar' , 200);
            $table->string('footer_content_en' , 200);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nav_bar_footer_content');
    }
};
