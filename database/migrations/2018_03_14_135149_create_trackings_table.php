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
            $table->string('number'); // TBA21321
            $table->string('tracking'); // 
            $table->text('description'); // descripción
            $table->integer('distributor_id')->unsigned(); // repartidor
            $table->integer('weight')->unsigned(); // peso(lb)
            $table->integer('tstate_id')->unsigned(); // estado del consolidado
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('distributor_id')->references('id')->on('distributors')->onDelete('cascade');
            $table->foreign('tstate_id')->references('id')->on('tstates')->onDelete('cascade');
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
