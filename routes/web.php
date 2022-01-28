<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Views\IndexController@index')->name('view.dashboard');
Route::get('/penjualan', 'Views\PenjualanController@index')->name('view.penjualan');

Route::prefix('test')->group(function () {
    Route::get('/db', function(){
        return DB::table('barang')->get();
    })->name('user');
});
