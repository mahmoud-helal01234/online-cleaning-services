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
        Schema::table('client_general_offer_orders', function (Blueprint $table) {

            $table->foreignId('general_offer_id')->constrained('general_offers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('invoice_id')->constrained('invoices')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_general_offer_orders', function (Blueprint $table) {
            //
        });
    }
};
