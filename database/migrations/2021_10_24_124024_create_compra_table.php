<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tienda_id')->unsigned();
            $table->bigInteger('proveedor_id')->unsigned();
            $table->bigInteger('forma_pago_id')->unsigned();
            $table->string('no_comprobante');
            $table->date('fecha_comprobante');
            $table->decimal('monto',7,2);
            $table->integer('anulada')->default(0);
            $table->bigInteger('usuario_id')->unsigned();
            $table->foreign('proveedor_id')->references('id')->on('proveedor');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pago');
            $table->foreign('tienda_id')->references('id')->on('tienda');
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
        Schema::dropIfExists('compra');
    }
}
