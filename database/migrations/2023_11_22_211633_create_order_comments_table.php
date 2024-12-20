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
        Schema::create('order_comments', function (Blueprint $table) {
            $table->id();
           // $table->unsignedInteger('order_id');
           $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
           //$table->unsignedInteger('user_id');
           $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
           $table->string('text', 500);
            $table->enum('show_for_client', ['yes', 'no']);
            $table->string('img_path' , 100);
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
        Schema::dropIfExists('order_comments');
    }
};
