<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('penjualan')->group(function () {
    Route::get('/', 'PenjualanController@list')->name('penjualan.list'); //limit=10
    Route::get('/grafik-bulan/{month}', 'PenjualanController@grafikBulan')->name('penjualan.grafik.bulan'); //month=12
    Route::get('/{id}', 'PenjualanController@detail')->name('penjualan.detail');
});

Route::prefix('barang')->group(function () {
    Route::get('/persentase-kategori', 'BarangController@persentaseKategori')->name('barang.kategori.persentase');
});


Route::prefix('test')->group(function () {
    Route::get('/', function () {
        return 'Hello World';
    });
});
