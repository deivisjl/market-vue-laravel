<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiendaUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tienda_usuario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tienda_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->integer('status')->default(1);
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('tienda_id')->references('id')->on('tienda');
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
        Schema::dropIfExists('tienda_usuario');
    }
}
