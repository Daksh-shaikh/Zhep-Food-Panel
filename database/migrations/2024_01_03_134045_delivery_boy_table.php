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
        Schema::create('delivery_boy', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('primary_contact');
            $table->integer('secondary_contact');
            $table->string('email');
            $table->string('password');
            $table->integer('city_id');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('account_number');
            $table->integer('aadhar_number');
            $table->string('driving_license_number');
            $table->string('documents');

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
        //
    }
};
