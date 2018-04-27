<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tracking_id')->unsigned()->nullable();
            $table->integer('consolidated_id')->unsigned()->nullable();
            $table->integer('event_id')->unsigned();
            $table->boolean('viewed')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tracking_id')->references('id')->on('trackings')->onDelete('cascade');
            $table->foreign('consolidated_id')->references('id')->on('consolidateds')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_users');
    }
}
