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

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/seleccionar-tienda', 'HomeController@tienda');
    Route::post('/elegir-tienda', 'HomeController@elegirTienda')->name('elegir-tienda');
    Route::get('/logout','Auth\LoginController@logout');

    Route::group(['middleware' => ['auth','tienda']], function(){
        /* Accesos */
    Route::resource('/categorias','Acceso\CategoriaController');

    Route::resource('/proveedores','Catalogos\ProveedorController');
    Route::get('/buscar-proveedores-nombre/{request}','Catalogos\ProveedorController@obtenerProveedores');

    //Route::resource('/unidades-de-medida','Catalogos\UnidadMedidaController');
    //Route::get('/obtener-unidad-medida','Catalogos\UnidadMedidaController@obtenerUnidadMedida');

    Route::resource('/formas-de-pago','Catalogos\FormaPagoController');
    Route::get('/obtener-forma-pago','Catalogos\FormaPagoController@obtenerFormaPago');

    Route::resource('/clientes','Catalogos\ClienteController');
    Route::resource('/productos','Catalogos\ProductoController');
    Route::get('/buscar-productos-nombre/{request}','Catalogos\ProductoController@obtenerProductos');

    Route::resource('/tiendas','Tienda\TiendaController');
    Route::get('/tiendas-deshabilitar/{request}','Tienda\TiendaController@deshabilitar');

    Route::resource('/compras','Compra\CompraController');

    Route::resource('/inventario','Inventario\InventarioController');
});
