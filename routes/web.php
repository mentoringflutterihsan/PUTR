<?php

use Illuminate\Support\Facades\{Route,Auth};


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
Route::get('/', 'PenggunaController@index');

Auth::routes();



/*
 * pembangunan Routes
 */
Route::get('/our_pembangunan', 'PembangunanMapController@index')->name('pembangunan_map.index');
Route::resource('pembangunan', 'PembangunanController');
Route::resource('pengguna', 'PenggunaController');
Route::resource('desa', 'DesaController');



Route::get('serverside','PenggunaController@serverside');
Route::get('/export', 'PembangunanController@export_excel');
// Route::POST('/desa','DropdownController@desa')->name('desa');
Route::get('/desa/{id}','DropdownController@desa');