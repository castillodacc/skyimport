<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country'); // pais
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rol'); // rol
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // nombre
            $table->string('last_name'); // apellido
            $table->string('email')->unique(); // correo
            $table->string('phone')->nullable(); // telefono
            $table->integer('num_id')->unsigned()->unique()->nullable(); // número de identificación
            $table->string('password'); // contraseña
            $table->integer('country_id')->unsigned()->nullable(); // pais_id
            $table->string('city')->nullable(); // ciudad
            $table->text('address')->nullable(); // dirección
            $table->text('address_two')->nullable(); // dirección 2
            $table->integer('rol_id')->unsigned()->default(1); // rol
            $table->rememberToken();
            $table->timestamps();

            // relaciones...
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
    }
}
