<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tienda_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->integer('cantidad_total');
            $table->decimal('precio_promedio');
            $table->bigInteger('tipo_operacion_id')->unsigned()->nullable();
            $table->integer('cantidad');
            $table->decimal('precio',7,2);
            $table->foreign('tienda_id')->references('id')->on('tienda');
            $table->foreign('producto_id')->references('id')->on('producto');
            $table->foreign('tipo_operacion_id')->references('id')->on('tipo_operacion');
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
        Schema::dropIfExists('inventario');
    }
}
