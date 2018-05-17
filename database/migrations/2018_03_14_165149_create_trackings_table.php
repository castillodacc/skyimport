<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tracking'); // TBA21321
            $table->text('description'); // descripción
            $table->integer('distributor_id')->unsigned(); // repartidor
            $table->float('price', 10, 2)->unsigned(); // price($)
            $table->integer('shippingstate_id')->unsigned()->default(11); // estado del tracking
            $table->integer('consolidated_id')->unsigned(); // consolidado
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('consolidated_id')->references('id')->on('consolidateds')->onDelete('cascade');
            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
            $table->foreign('shippingstate_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trackings');
    }
}
