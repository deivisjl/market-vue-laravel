<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tienda_id')->unsigned();
            $table->date('fecha_inicio');
            $table->string('hora_inicio');
            $table->date('fecha_cierre')->nullable();
            $table->string('hora_cierre')->nullable();
            $table->decimal('saldo_inicial',8,2);
            $table->decimal('ingresos',8,2)->nullable();
            $table->integer('activo')->default(1);
            $table->bigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
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
        Schema::dropIfExists('caja');
    }
}
