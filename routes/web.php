<?php

use Illuminate\Support\Facades\{Route,Auth};

Route::get('/', 'PenggunaController@index');

Route::group([
    'middleware' => 'auth'
], function() {
    Route::get('/our_pembangunan', 'PembangunanMapController@index')->name('pembangunan_map.index');

    Route::get('pembangunan/datatable', 'PembangunanController@dataTable');
    Route::get('pembangunan/export-excel/{tahun}', 'PembangunanController@exportExcel');
    Route::resource('pembangunan', 'PembangunanController');

    Route::resource('pengguna', 'PenggunaController');
    Route::resource('desa', 'DesaController');
    Route::get('kecamatan/{id}/desa','DropdownController@getDesaByKecamatan');
});

Auth::routes();