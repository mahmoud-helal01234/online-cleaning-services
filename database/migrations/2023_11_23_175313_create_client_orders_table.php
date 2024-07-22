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
        Schema::create('client_orders', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('client_id');
            $table->foreignId('client_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('company_id');
            $table->foreignId('company_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('delivery_type_id');
            $table->foreignId('delivery_type_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('promo_code_id');
            $table->foreignId('promo_code_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('client_location_id');
            $table->foreignId('client_location_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('invoice_id');
            //$table->foreignId('invoice_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_orders');
    }
};
