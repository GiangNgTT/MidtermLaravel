<?php

use App\Http\Controllers\CateAPIController;
use App\Http\Controllers\DishAPIController;
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
Route::apiResource('dishes', DishAPIController::class);
Route::apiResource('categories', CateAPIController::class);
Route::get('show', [DishAPIController::class, 'search']);
