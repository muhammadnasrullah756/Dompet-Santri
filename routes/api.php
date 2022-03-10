<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\TransaksiController;

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
// Login register

Route::post('registeruser', 'UserController@register');
Route::post('login', 'UserController@login');
Route::middleware('auth:sanctum')->post('logout', 'UserController@logout');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Isi Saldo

// Route::middleware('auth:sanctum')->get('pengajuan', 'SaldoController@showall');
Route::middleware('auth:sanctum')->post('isi', 'SaldoController@addSaldo');
Route::middleware('auth:sanctum')->get('detail/{id}', 'SaldoController@detail');
Route::middleware('auth:sanctum')->get('historydashboard', 'SaldoController@historydashboard');
Route::middleware('auth:sanctum')->get('transfer', 'SaldoController@transfer');
Route::middleware('auth:sanctum')->get('coba', 'SaldoController@coba');

// Tarik dana

Route::middleware('auth:sanctum')->group(function () {

Route::get('ke_tarik_dana',[BalanceController::class,'show_withdrawal']);
Route::post('tarik_dana',[BalanceController::class,'withdraw']);

// CRUD katalog

Route::get('home',[KatalogController::class,'home']);
Route::post('store',[KatalogController::class,'store']);
Route::get('barang/{id}',[KatalogController::class,'show_one']);
Route::put('edit/{id}',[KatalogController::class,'edit']);
Route::delete('delete_barang/{id}',[KatalogController::class,'delete']);

// Cart Section
Route::post('keranjang/{id}',[TransaksiController::class,'add_barang']);
Route::delete('hapus_keranjang/{id}',[TransaksiController::class,'delete_cart']);
Route::put('tambah_barang/{id}',[TransaksiController::class,'tambahkan_barang']);
Route::put('kurangi_barang/{id}',[TransaksiController::class,'kurangi_barang']);

// Checkout, transaksi

Route::post('tambahkan_barang',[TransaksiController::class,'tambahkan_barang']);



Route::get('data_transaksi',[TransaksiController::class,'get_transaksi_data']);
Route::get('show_transaksi/{id}',[TransaksiController::class,'show_transaksi']);



Route::post('accept', 'SaldoController@accept');
});
