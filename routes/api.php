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

Route::get('/petro',"PetroController@getPetroPrice");

Route::post('/user',"Auth\AuthController@register");
Route::post('/saveFiles',"UserController@saveFiles");
Route::post('/save-client',"ClientController@store");
Route::post('/clients/save-files',"ClientController@saveFiles");
Route::get('/restructureNewData','ServiceRequestController@scriptNewStructure');
Route::get('/users/getByRequest/{id}','UserController@getUserByRequest');

Route::middleware('auth')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users','UserController@getUsers')->middleware('isNotClient');
    Route::get('/users/destroy/{id}','UserController@deleteUser')->middleware('isAdminOrDirector');
    Route::get('/users/{status}/{id}','UserController@setStatusUser')->middleware('isNotClient');
    Route::post('/users/updateRole','UserController@setRoleUser')->middleware('isNotClient');
    Route::post('/users/updateUser','UserController@updateUser');
    Route::get('serviceRequest/download/{id}', 'ServiceRequestController@downloadRequestService');

    //-----------------SERVICIOS--------------------
    Route::get('/services','ServiceController@index');
    Route::post('/services','ServiceController@store')->middleware('isNotClient');
    Route::post('/services/{id}','ServiceController@update')->middleware('isNotClient');
    Route::delete('/services/{id}','ServiceController@destroy')->middleware('isNotClient');

    //-----------------------SOLICITUD DE SERVICIOS------------------
    Route::post('/service-request','ServiceRequestController@store');
    Route::get('/requests/me','ServiceRequestController@myRequests');
    Route::get('/requests/manage','ServiceRequestController@manageRequest')->middleware('isNotClient');
    Route::post('/requests/{id}/save-dates','ServiceRequestController@saveDates')->middleware('isNotClient');
    Route::post('/requests/{id}/save-hour','ServiceRequestController@saveHour')->middleware('isNotClient');
    Route::post('/requests/{id}/save-client-date','ServiceRequestController@saveClientDate');
    Route::post('/requests/{id}/finish','ServiceRequestController@requestFinish')->middleware('isNotClient');
    Route::post('/requests/updateCorrelative','ServiceRequestController@updateCorrelative')->middleware('isAdminOrDirector');
    Route::get('/requests/all','ServiceRequestController@allRequests')->middleware('isNotClient');
    Route::get('/requests/pending','ServiceRequestController@requestByResponse')->middleware('isAdminOrDirector');
    Route::get('/requests/review','ServiceRequestController@requestByReview')->middleware('isNotClient');
    Route::get('/requests/by-status/{:status}','ServiceRequestController@getRequestsByStatus')->middleware('isNotClient');
    Route::get('/requests/save/{action}/{id}','ServiceRequestController@saveResponse')->middleware('isNotClient');
    Route::get('/requests/active','ServiceRequestController@serviceRequestActive');
    Route::get('/requests/generate-to-sign-file/{id}',"ServiceRequestController@generateToSignFile");
    Route::post('/requests/save-sign-file',"ServiceRequestController@saveFiles");


    //-----------------------ESTADISTICAS-----------------------
    Route::get('/statistics/cardsUpper','StatisticsController@cardsUpper')->middleware('isNotClient');
    Route::get('/statistics/requestsByStatus','StatisticsController@requestsByStatus')->middleware('isNotClient');
    Route::get('/statistics/requestsByYear','StatisticsController@requestsByYear')->middleware('isNotClient');
    Route::get('/statistics/incomeByYear','StatisticsController@incomeByYear')->middleware('isNotClient');
    Route::get('/statistics/mostRequestedServices','StatisticsController@mostRequestedServices')->middleware('isNotClient');


    Route::get('/get-files/{id?}',"UserController@getFiles");
    Route::post('/download-file',"UserController@downloadFile");
    Route::post('/delete-file',"UserController@deleteFile");

    Route::get('/send-reminder/{id}',"ServiceRequestController@sendReminder");

    //---------------------------------ROLES-------------------------
    Route::get('/roles',"RoleController@index");

    //---------------------------------- CLIENTES ----------------------------------------------------

    Route::get('/clients/{requestId}',"ClientController@index");
    Route::get('/clients/get-files/{requestId}',"ClientController@getFiles");
    Route::get('/clients/destroy/{clientId}',"ClientController@destroy");

    //--------------------------------PRECIO PETRO------------------
    Route::post('/petro',"PetroController@updatePetroPrice");

});
