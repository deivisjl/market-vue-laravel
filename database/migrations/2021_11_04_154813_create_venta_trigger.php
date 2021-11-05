<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER Venta_Producto AFTER INSERT ON `detalle_venta` FOR EACH ROW
            BEGIN
                DECLARE tmp_tipo_operacion INT;
                DECLARE tmp_precio DECIMAL(8,2);
                DECLARE tmp_cantidad DECIMAL(8,2);
                DECLARE tmp_promedio DECIMAL(8,2);
                DECLARE tmp_id INT;

                DECLARE MESSAGE_ERROR varchar(255);

                SET tmp_id := 0;
                SET tmp_tipo_operacion := 2;

                SELECT id, cantidad_total, precio_promedio INTO tmp_id, tmp_cantidad, tmp_precio FROM inventario WHERE id = (SELECT MAX(id) FROM inventario WHERE tienda_id = NEW.tienda_id AND producto_id = NEW.producto_id);

                IF tmp_cantidad >= NEW.cantidad THEN
                    SET tmp_promedio := tmp_precio;
                    INSERT INTO inventario (tienda_id,producto_id,cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at)
                    VALUES(NEW.tienda_id,NEW.producto_id,(tmp_cantidad - NEW.cantidad),tmp_promedio,tmp_tipo_operacion,NEW.cantidad,NEW.precio_unitario,now());

                    UPDATE vista_inventario SET stock = (tmp_cantidad - NEW.cantidad), precio = tmp_promedio where tienda_id = NEW.tienda_id AND producto_id = NEW.producto_id;
                ELSE
                    SIGNAL SQLSTATE \'45000\';
                    SET MESSAGE_ERROR = \'El stock es menor a la venta\';
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `Venta_Producto`');
    }
}
