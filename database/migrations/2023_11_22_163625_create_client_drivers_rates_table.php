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
        Schema::create('client_drivers_rates', function (Blueprint $table) {

            $table->id();
            // $table->unsignedInteger('client_id');
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('cascade');
            //$table->unsignedInteger('company_id');
            $table->foreignId('company_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            //$table->unsignedInteger('base_companies_rate_id');
            $table->foreignId('base_companies_rate_id')->constrained('base_companies_rates')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('value', ['1', '2', '3', '4', '5']);
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
        Schema::dropIfExists('client_drivers_rates');
    }
};
