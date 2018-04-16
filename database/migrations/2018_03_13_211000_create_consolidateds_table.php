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
            $table->integer('user_id')->unsigned(); // usuario
            $table->integer('shippingstate_id')->unsigned()->default(1); // estado del consolidado
            $table->string('weight')->nullable()->default(null); // peso
            $table->integer('bill')->nullable()->default(null); // factura
            $table->timestamp('closed_at')->nullable(); // fecha de cierre
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shippingstate_id')->references('id')->on('shippingstates')->onDelete('cascade');
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
