<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KatalogController;

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

Route::post('registeruser', 'UserController@register');
Route::post('login', 'UserController@login');
Route::middleware('auth:sanctum')->post('logout', 'UserController@logout');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// CRUD katalog

Route::get('home',[KatalogController::class,'home']);
Route::post('store',[KatalogController::class,'store']);
Route::get('barang/{id}',[KatalogController::class],'show_one');
Route::put('edit/{id}',[KatalogController::class],'edit');
Route::delete('delete_barang/{id}',[KatalogController::class],'delete');