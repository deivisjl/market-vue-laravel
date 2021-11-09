<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    Auth::routes(['register' => false, 'reset' => false]);

    Route::get('/', 'HomeController@index')->name('home')->middleware('tienda');
    Route::get('/home', 'HomeController@index')->name('home')->middleware('tienda');
    Route::get('/seleccionar-tienda', 'HomeController@tienda');
    Route::post('/elegir-tienda', 'HomeController@elegirTienda')->name('elegir-tienda');

    Route::get('/aperturar-caja','HomeController@aperturaCaja')->middleware('tienda');
    Route::post('/registrar-apertura','HomeController@registrarApertura')->name('aperturar')->middleware('tienda');
    Route::get('/registrar-cierre','HomeController@registrarCierre')->name('cerrar')->middleware(['tienda','caja']);

    Route::get('/logout','Auth\LoginController@logout');

    Route::group(['middleware' => ['auth','tienda']], function(){
        /* Accesos */
        Route::resource('/categorias','Acceso\CategoriaController');

        Route::resource('/proveedores','Catalogos\ProveedorController');
        Route::get('/buscar-proveedores-nombre/{request}','Catalogos\ProveedorController@obtenerProveedores');
        Route::post('/guardar-nuevo-proveedor','Catalogos\ProveedorController@guardarNuevoProveedor');

        Route::resource('/formas-de-pago','Catalogos\FormaPagoController');
        Route::get('/obtener-forma-pago','Catalogos\FormaPagoController@obtenerFormaPago');

        Route::resource('/clientes','Catalogos\ClienteController');
        Route::get('/buscar-clientes-nombre/{request}','Catalogos\ClienteController@obtenerClientes');
        Route::post('/guardar-nuevo-cliente','Catalogos\ClienteController@guardarNuevoCliente');

        Route::resource('/productos','Catalogos\ProductoController');
        Route::get('/buscar-productos-nombre/{request}','Catalogos\ProductoController@obtenerProductos');
        Route::get('/productos-por-nombre/{request}','Catalogos\ProductoController@buscarProductoNombre');
        Route::get('/buscar-producto-transferencia/{request}','Catalogos\ProductoController@buscarProductoTransferencia');

        Route::resource('/tiendas','Tienda\TiendaController');
        Route::get('/tiendas-deshabilitar/{request}','Tienda\TiendaController@deshabilitar');
        Route::get('/listar-tiendas','Tienda\TiendaController@listarTiendas');
        Route::get('/cambiar-tienda','Tienda\TiendaController@cambiarTienda')->name('cambiar-tienda');

        Route::resource('/compras','Compra\CompraController');
        Route::get('/compras-detalle/{id}','Compra\CompraController@detalle');

        Route::resource('/ventas','Venta\VentaController',['except' => ['create']]);
        Route::get('/ventas-detalle/{id}','Venta\VentaController@detalle');
        Route::get('/punto-de-venta','Venta\VentaController@create')->name('ventas.create')->middleware('caja');

        Route::resource('/inventario','Inventario\InventarioController');
        Route::get('/inventario-detalle/{id}','Inventario\InventarioController@detalle');
        Route::get('/inventario-detalle-producto/{request}','Inventario\InventarioController@detalleProducto');
        Route::get('/transferencia-de-productos','Inventario\InventarioController@transferencia')->name('transferencia');
        Route::post('/guardar-transferencia','Inventario\InventarioController@crearTransferencia');

        Route::resource('/usuarios','Usuario\UsuarioController');
        Route::get('/mi-perfil','Usuario\UsuarioController@miPerfil');
        Route::post('/actualizar-mi-perfil','Usuario\UsuarioController@actualizarMiPerfil')->name('usuarios.perfil');
        Route::post('/actualizar-mi-credencial','Usuario\UsuarioController@actualizarMiCredencial')->name('usuarios.pass');

        Route::get('/reportes-graficos','Reportes\ReporteController@grafico');
        Route::post('/grafico-producto-mas-vendido','Reportes\ReporteController@graficoProductoMasVendido');
        Route::post('/grafico-producto-por-agotarse','Reportes\ReporteController@graficoProductoPorAgotarse');

        Route::get('/reportes-pdf','Reportes\ReporteController@pdf');
    });
