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
        Schema::create('companies_working_with_drivers_managers', function (Blueprint $table) {
            $table->id();
           // $table->unsignedInteger('company_id');
           $table->foreignId('company_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->name('company_id_with_drivers_manager_foreign');
            //$table->unsignedInteger('drivers_manager_id');
            $table->foreignId('drivers_manager_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade')->name('drivers_manager_id_with_company_foreign');
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
        Schema::dropIfExists('companies_working_with_drivers_managers');
    }
};
