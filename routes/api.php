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


Route::post('/user',"Auth\AuthController@register");

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    //-----------------SERVICIOS--------------------
    Route::get('/services','ServiceController@index');
    Route::post('/services','ServiceController@store');
    Route::post('/services/{id}','ServiceController@update');
    Route::delete('/services/{id}','ServiceController@destroy');

    //-----------------------SOLICITUD DE SERVICIOS------------------
    Route::post('/service-request','ServiceRequestController@store');
    Route::get('/requests/me','ServiceRequestController@myRequests');

    Route::get('/requests/pending','ServiceRequestController@requestByResponse')->middleware('isAdminOrDirector');
    Route::get('/requests/save/{action}/{id}','ServiceRequestController@saveResponse')->middleware('isAdminOrDirector');
});
