<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tienda_id')->unsigned();
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('forma_pago_id')->unsigned();
            $table->bigInteger('usuario_id')->unsigned();
            $table->string('no_factura');
            $table->bigInteger('correlativo');
            $table->date('fecha_factura')->default(Carbon::now()->format('Y-m-d'));
            $table->decimal('monto',8,2);
            $table->decimal('ganancia',8,2)->nullable();
            $table->foreign('cliente_id')->references('id')->on('cliente');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pago');
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
        Schema::dropIfExists('venta');
    }
}
