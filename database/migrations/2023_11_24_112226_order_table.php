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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('order_id2');
            $table->integer('user_id');
            $table->integer('restro_id');
            $table->date('order_date');
            // $table->integer('recipe_price');
            $table->integer('contact_number');
            $table->string('address');
            $table->integer('total');
            $table->integer('discount');
            $table->string('payment_mode');
            $table->string('delivery_type');
            $table->integer('delivery_charges');
            $table->integer('coupon_code');
            $table->string('status');
            $table->string('restro_status');
            $table->string('delivery_status');
            $table->string('longitude');
            $table->string('latitude');
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
