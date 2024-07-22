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
        Schema::create('wallet_credit_offers', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar', 100);
            $table->string('name_en', 100);
            $table->string('description_ar', 200);
            $table->string('description_en', 200);
            $table->string('img_path', 100);
            $table->boolean('value');
            $table->enum('value_type', ['constant', 'percentage']);
            $table->double('min_amount');
            $table->double('max_amount');
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
        Schema::dropIfExists('wallet_credit_offers');
    }
};
