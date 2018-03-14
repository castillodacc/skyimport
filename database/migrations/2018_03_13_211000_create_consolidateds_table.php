<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsolidatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidateds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number'); // is4124124124214
            $table->integer('user_id')->unsigned()->unique(); // usuario
            $table->integer('state_id')->unsigned()->unique(); // estado del consolidado
            $table->timestamp('close_at')->nullable(); // fecha de cierre
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consolidateds');
    }
}
