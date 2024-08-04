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
        Schema::create('restro', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('restaurant');
            $table->string('address');
            $table->double('latitude', 10, 6); // 10 total digits, 6 digits after the decimal point
            $table->double('longitude', 10, 6);
            $table->string('contact_person');
            $table->integer('mobilenumber');
            $table->string('email');
            $table->string('password');
            $table->string('avg_cooking_time');
            $table->string('banner');
            $table->string('category');
            $table->string('food');
            $table->string('details');
            $table->string('status');
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
