<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('producto_id')->unsigned();
            $table->bigInteger('compra_id')->unsigned();
            $table->integer('cantidad');
            $table->bigInteger('unidad_medida_id')->unsigned();
            $table->decimal('precio_unitario',7,2);
            $table->foreign('producto_id')->references('id')->on('producto');
            $table->foreign('compra_id')->references('id')->on('compra');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medida');
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
        Schema::dropIfExists('detalle_compra');
    }
}
