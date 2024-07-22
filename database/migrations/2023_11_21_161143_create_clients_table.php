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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name' , 50);
            $table->string('avatar', 100)->nullable();
            $table->string('phone', 20);
            $table->foreignId('country_id')->constrained('countries')->onUpdate('cascade')->onDelete('cascade');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->text('access_token');
            $table->string('provider', 100);
            $table->string('provider_id', 50);
            $table->string('provider_name', 50);

            $table->boolean('active');

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
        Schema::dropIfExists('clients');
    }
};
