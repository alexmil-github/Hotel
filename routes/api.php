<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::post('/login', [Controllers\UserController::class, 'login']);
Route::get('/logout', [Controllers\UserController::class, 'logout'])->middleware('auth:api');

Route::apiResource('user', Controllers\UserController::class)->middleware('auth:api');

Route::get('/booking', [Controllers\BookingController::class, 'index'])->middleware('auth:api');
Route::patch('/booking/{id}', [Controllers\BookingController::class, 'update'])->middleware('auth:api');
Route::post('/booking', [Controllers\BookingController::class, 'store']);
Route::get('/booking/{code}', [Controllers\BookingController::class, 'show']);


Route::apiResource('price', Controllers\PriceController::class)->middleware('auth:api');


Route::get('/calculation', [Controllers\PriceController::class, 'calculation']);

Route::apiResource('photo', Controllers\PhotoController::class)->middleware('auth:api');

Route::get('/category', [Controllers\CategoryController::class, 'index']);
Route::get('/category/{id}', [Controllers\CategoryController::class, 'show']);
Route::get('/category/{id}/price', [Controllers\PriceController::class, 'showPrices']);

Route::get('/user/{user}/to-dismiss', [Controllers\UserController::class, 'toDismiss'])->middleware('auth:api');;

