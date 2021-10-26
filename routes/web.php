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
Route::get('/seleccionar-tienda', 'HomeController@tienda');
Route::post('/elegir-tienda', 'HomeController@elegirTienda')->name('elegir-tienda');
Route::get('/logout','Auth\LoginController@logout');

/* Accesos */
Route::resource('/categorias','Acceso\CategoriaController');
Route::resource('/proveedores','Catalogos\ProveedorController');
Route::resource('/unidades-de-medida','Catalogos\UnidadMedidaController');
Route::resource('/formas-de-pago','Catalogos\FormaPagoController');
Route::resource('/clientes','Catalogos\ClienteController');
