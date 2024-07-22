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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->double('first_order_cash_back_value');
            $table->enum('first_order_cash_back_value_type', ['percentage', 'constant']);
            $table->double('invitation_code_owner_cash_value');
            $table->enum('invitation_code_owner_cash_value_type', ['percentage', 'constant']);
            $table->double('invitation_code_user_cash_value');
            $table->enum('invitation_code_user_cash_value_type', ['percentage', 'constant']);
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
        Schema::dropIfExists('settings');
    }
};
