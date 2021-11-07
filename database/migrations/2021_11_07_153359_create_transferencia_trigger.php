<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferenciaTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER Transferencia_Trigger AFTER INSERT ON `transferencia` FOR EACH ROW
            BEGIN
                DECLARE tmp_tipo_operacion INT;
                DECLARE tmp_precio_destino DECIMAL(8,2);
                DECLARE tmp_cantidad_destino DECIMAL(8,2);
                DECLARE tmp_promedio_destino DECIMAL(8,2);
                DECLARE tmp_destino_id INT;

                DECLARE tmp_precio_origen DECIMAL(8,2);
                DECLARE tmp_cantidad_origen DECIMAL(8,2);
                DECLARE tmp_promedio_origen DECIMAL(8,2);
                DECLARE tmp_origen_id INT;

                DECLARE MESSAGE_ERROR varchar(255);

                SET tmp_destino_id := 0;
                SET tmp_origen_id := 0;
                SET tmp_tipo_operacion_ingreso := 3;
                SET tmp_tipo_operacion_salida := 4;

                SELECT id, cantidad_total, precio_promedio INTO tmp_destino_id, tmp_cantidad_destino, tmp_precio_destino FROM inventario WHERE id = (SELECT MAX(id) FROM inventario WHERE tienda_id = NEW.tienda_destino_id AND producto_id = NEW.producto_id);
                SELECT id, cantidad_total, precio_promedio INTO tmp_origen_id, tmp_cantidad_origen, tmp_precio_origen FROM inventario WHERE id = (SELECT MAX(id) FROM inventario WHERE tienda_id = NEW.tienda_origen_id AND producto_id = NEW.producto_id);

                IF tmp_cantidad_origen >= NEW.cantidad THEN
                    IF tmp_destino_id > 0 THEN
                        INSERT INTO inventario (tienda_id, producto_id, cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at)
                        VALUES(NEW.tienda_destino_id, NEW.producto_id, (tmp_cantidad_destino + NEW.cantidad), tmp_precio_destino, tmp_tipo_operacion_ingreso, NEW.cantidad, NEW.precio, now());

                        UPDATE vista_inventario SET stock = (tmp_cantidad_destino + NEW.cantidad), precio = tmp_precio_destino where tienda_id = NEW.tienda_destino_id AND producto_id = NEW.producto_id;
                    ELSE
                        INSERT INTO inventario (tienda_id, producto_id, cantidad_total, precio_promedio,tipo_operacion_id,cantidad,precio,created_at)
                        VALUES (NEW.tienda_destino_id, NEW.producto_id, NEW.cantidad, NEW.precio, tmp_tipo_operacion_ingreso, NEW.cantidad, NEW.precio, now());

                        INSERT INTO vista_inventario(tienda_id,producto_id,stock,precio) VALUES(NEW.tienda_destino_id, NEW.producto_id,NEW.cantidad,NEW.precio);
                    END IF;

                    INSERT INTO inventario (tienda_id,producto_id,cantidad_total,precio_promedio,tipo_operacion_id,cantidad,precio,created_at)
                    VALUES(NEW.tienda_origen_id,NEW.producto_id,(tmp_cantidad_origen - NEW.cantidad),tmp_precio_origen,tmp_tipo_operacion_salida,NEW.cantidad,NEW.precio,now());

                    UPDATE vista_inventario SET stock = (tmp_cantidad_origen - NEW.cantidad), precio = tmp_precio_origen where tienda_id = NEW.tienda_origen_id AND producto_id = NEW.producto_id;

                ELSE
                    SIGNAL SQLSTATE \'45000\';
                    SET MESSAGE_ERROR = \'El stock es menor a la transferencia\';
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
        DB::unprepared('DROP TRIGGER IF EXISTS `Transferencia_Trigger`');
    }
}
