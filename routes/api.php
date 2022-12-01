<?php

use App\Http\Controllers\ProductController;
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


Route::resource('stock', \App\Http\Controllers\StockController::class);
Route::resource('ingredient', \App\Http\Controllers\IngredientController::class);
Route::resource('product', \App\Http\Controllers\ProductController::class);
Route::resource('order', \App\Http\Controllers\OrderController::class);
Route::post('order/payload-order', [\App\Http\Controllers\OrderController::class, 'getPayloadOrder']);


