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
        Schema::create('companies', function (Blueprint $table) {
            //$table->unsignedInteger('user_id')->primary();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->primary();
            $table->string('name_ar' , 100);
            $table->string('name_en' , 100);
            $table->string('logo_path', 80)->nullable();
            $table->string('cover_path', 80)->nullable();
            $table->integer('orders_per_hour');
            //$table->unsignedInteger('country_id');
            $table->foreignId('country_id')->constrained('countries')->onUpdate('cascade')->onDelete('cascade');
            //$table->boolean('active')->default(1);
            $table->softDeletes();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
