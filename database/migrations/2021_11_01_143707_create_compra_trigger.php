<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompraTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER Compra_Producto AFTER INSERT ON `detalle_compra` FOR EACH ROW
            BEGIN
                DECLARE tmp_tipo_operacion INT;
                DECLARE tmp_precio DECIMAL(8,2);
                DECLARE tmp_cantidad DECIMAL(8,2);
                DECLARE tmp_promedio DECIMAL(8,2);
                DECLARE tmp_id INT;

                DECLARE new_precio DECIMAL(7,2);
                DECLARE new_cantidad DECIMAL(8,2);

                SET tmp_id := 0;
                SET tmp_tipo_operacion := 1;
                SET new_precio := NEW.precio_unitario;
                SET new_cantidad := NEW.cantidad;

                SELECT id, cantidad_total, precio_promedio INTO tmp_id, tmp_cantidad, tmp_precio FROM inventario WHERE id = (SELECT MAX(id) FROM inventario WHERE tienda_id = NEW.tienda_id AND producto_id = NEW.producto_id);
                IF tmp_id > 0 THEN
                    SET tmp_promedio := ((tmp_cantidad * tmp_precio)+(new_cantidad * new_precio))/(tmp_cantidad + new_cantidad);
                    INSERT INTO inventario (tienda_id, producto_id, cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at)
                    VALUES(NEW.tienda_id, NEW.producto_id, (tmp_cantidad + new_cantidad), tmp_promedio, tmp_tipo_operacion, new_cantidad, new_precio, now());

                    UPDATE vista_inventario SET stock = (tmp_cantidad + new_cantidad), precio = tmp_promedio where tienda_id = NEW.tienda_id AND producto_id = NEW.producto_id;
                ELSE
                    INSERT INTO inventario (tienda_id, producto_id, cantidad_total, precio_promedio,tipo_operacion_id,cantidad,precio,created_at)
                    VALUES (NEW.tienda_id, NEW.producto_id, new_cantidad, new_precio, tmp_tipo_operacion, new_cantidad, new_precio, now());

                    INSERT INTO vista_inventario(tienda_id,producto_id,stock,precio) VALUES(NEW.tienda_id, NEW.producto_id,new_cantidad,new_precio);
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
        DB::unprepared('DROP TRIGGER IF EXISTS `Compra_Producto`');
    }
}
