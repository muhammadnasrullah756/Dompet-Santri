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

Route::post('isi', 'SaldoController@addSaldo');

// Tarik dana

Route::get('ke_tarik_dana',[BalanceController::class,'show_withdrawal']);
Route::post('tarik_dana',[BalanceController::class,'withdraw']);

// CRUD katalog

Route::get('home',[KatalogController::class,'home']);
Route::post('store',[KatalogController::class,'store']);
Route::get('barang/{id}',[KatalogController::class,'show_one']);
Route::put('edit/{id}',[KatalogController::class,'edit']);
Route::delete('delete_barang/{id}',[KatalogController::class,'delete']);

// Checkout, transaksi

Route::post('tambahkan_barang',[TransaksiController::class,'tambahkan_barang']);
Route::get('data_transaksi',[TransaksiController::class,'get_transaksi_data']);
Route::get('show_transaksi/{id}',[TransaksiController::class,'show_transaksi']);

// Route::post('tambahkan_barang',[]);
