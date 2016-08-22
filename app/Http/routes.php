<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function(){
  return view('inicio');
})->name('inicio');

Route::get('regproducto', function(){
  return view('regproducto');
})->name('regproducto');

Route::get('entradap', function(){
  return view('conentradap');
});
Route::get('entradapu','EntradaController@llenartabla');

Route::get('regentrada', 'EntradaController@mostrar')->name('regentrada');
Route::get('regsalida', 'SalidaController@mostrar')->name('regsalida');

Route::resource('entrada','EntradaController');
Route::resource('salida','SalidaController');
Route::resource('producto', 'ProductoController');

Route::get('select/{id}', 'EntradaController@select')->name('select');
Route::get('select_sal/{id}', 'SalidaController@select_sal')->name('select_sal');

Route::get('listar','ProductoController@listar');
Route::get('search/{dato}/{tipo}','ProductoController@search');
Route::post('buscar','EntradaController@buscar')->name('buscar');
