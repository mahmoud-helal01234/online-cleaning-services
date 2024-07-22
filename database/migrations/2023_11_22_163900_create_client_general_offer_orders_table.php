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
        Schema::create('client_general_offer_orders', function (Blueprint $table) {
            $table->id();
            //$table->unsignedInteger('client_id');
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('cascade');
            //$table->unsignedInteger('general_offer_id');
            //$table->foreignId('general_offer_id')->constrained('general_offers')->onUpdate('cascade')->onDelete('cascade');
            // $table->unsignedInteger('invoice_id');
            // $table->foreignId('invoice_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('content', 300);
            $table->enum('status', ['waiting', 'done']);
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
        Schema::dropIfExists('client_general_offer_orders');
    }
};
