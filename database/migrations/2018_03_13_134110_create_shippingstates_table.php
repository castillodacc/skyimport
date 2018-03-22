<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippingstates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ref_id')->unsigned(); // FK 1) consolidados - 2) trackings
            $table->string('state'); // estados de trackings / consolidados
            $table->text('description')->nullable(); // description
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
        Schema::dropIfExists('tstates');
    }
}
