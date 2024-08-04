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
        Schema::create('counter_bill_items', function (Blueprint $table) {
            $table->id();
            $table->integer('counter_bill_id');
            $table->string('item_id');
            $table->string('item');
            $table->string('quantity');
            $table->string('price_id');
            $table->string('price');
            $table->string('total');

            $table->timestamps();
        });    }

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
