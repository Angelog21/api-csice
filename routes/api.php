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

Route::middleware('auth:sanctum')->group(function () {

    //-----------------SERVICIOS--------------------
    Route::get('/services','ServiceController@index');
    Route::post('/services','ServiceController@store');
    Route::post('/services/{id}','ServiceController@update');
    Route::delete('/services/{id}','ServiceController@destroy');

    //-----------------------SOLICITUD DE SERVICIOS------------------
});
