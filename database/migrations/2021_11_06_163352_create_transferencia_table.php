<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('boleta_referencia');
            $table->bigInteger('tienda_origen_id')->unsigned();
            $table->bigInteger('tienda_destino_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->integer('cantidad');
            $table->decimal('precio',8,2);
            $table->text('quien_solicito_traslado');
            $table->text('quien_autorizo_traslado');
            $table->text('motivo');
            $table->date('fecha');
            $table->bigInteger('usuario_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('producto');
            $table->foreign('tienda_origen_id')->references('id')->on('tienda');
            $table->foreign('tienda_destino_id')->references('id')->on('tienda');
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
        Schema::dropIfExists('transferencia');
    }
}
