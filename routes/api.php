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

    Route::get('/users','UserController@getUsers')->middleware('isNotClient');
    Route::get('/users/{status}/{id}','UserController@setStatusUser')->middleware('isNotClient');

    //-----------------SERVICIOS--------------------
    Route::get('/services','ServiceController@index');
    Route::post('/services','ServiceController@store')->middleware('isNotClient');
    Route::post('/services/{id}','ServiceController@update')->middleware('isNotClient');
    Route::delete('/services/{id}','ServiceController@destroy')->middleware('isNotClient');

    //-----------------------SOLICITUD DE SERVICIOS------------------
    Route::post('/service-request','ServiceRequestController@store');
    Route::get('/requests/me','ServiceRequestController@myRequests');
    Route::get('/requests/manage','ServiceRequestController@manageRequest')->middleware('isNotClient');
    Route::get('/requests/pending','ServiceRequestController@requestByResponse')->middleware('isAdminOrDirector');
    Route::get('/requests/save/{action}/{id}','ServiceRequestController@saveResponse')->middleware('isAdminOrDirector');
});
