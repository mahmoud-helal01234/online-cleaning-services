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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('client_id');
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('cascade');
            //$table->unsignedInteger('client_order_id');
            $table->foreignId('client_order_id')->constrained('client_orders')->onUpdate('cascade')->onDelete('cascade');

            //$table->unsignedInteger('drivers_app_order_id');
            $table->foreignId('drivers_app_order_id')->constrained('drivers_app_orders', 'order_id')->onUpdate('cascade')->onDelete('cascade');

            $table->decimal('tax_value', 10, 2);
            $table->enum('tax_value_type', ['percentage', 'constant']);

            $table->decimal('discount_value', 10, 2);
            $table->enum('discount_value_type', ['percentage', 'constant']);

            $table->decimal('minimum_charge', 5, 2);
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
        Schema::dropIfExists('invoices');
    }
};
