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
        Schema::create('category_restro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('restro');
            $table->timestamps();


            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('restro')->references('id')->on('restro')->onDelete('cascade');

             // Add additional columns if needed for the relationship
            // $table->integer('additional_column')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_restro');
    }
};
