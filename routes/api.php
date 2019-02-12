<?php

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Http\Resources\PatientResource;
use App\Http\Resources\MbcaResource;
use App\Models\Mbca;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

Route::middleware('auth:api')->get('/me', function (Request $request) {
    return new UserResource($request->user());
});

Route::post('login', 'Auth\UserController@login');
Route::post('logout', 'Auth\UserController@logout');

Route::get('test', function () {
    return response()->json(['message' => 'Test route'],200);
});

Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    Route::post('register', 'Auth\UserController@register');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('update', 'Auth\UserController@update');
    Route::get('users', 'Auth\UserController@getUsers');
    Route::delete('users/{id}', 'Auth\UserController@destroy');
    Route::get('patients/research-project', 'Patients\\PatientController@researchProject');
    Route::get('patients/export/{id}', 'Patients\\PatientController@export');
    Route::get('patients/export', 'Patients\\PatientController@export');
    Route::resource('patients', 'Patients\\PatientController');
    Route::resource('patients/customfields', 'CustomFields\\PatientCustomFieldController');
    Route::get('mbca/ethnicicties', 'Devices\\MbcaController@ethnicicties');
    Route::get('mbca/export/{id}', 'Devices\\MbcaController@export');
    Route::get('mbca/export', 'Devices\\MbcaController@export');
    Route::resource('mbca', 'Devices\\MbcaController');
    Route::get('bodpod/activities', 'Devices\\BodpodController@activities');
    Route::get('bodpod/export/{id}', 'Devices\\BodpodController@export');
    Route::get('bodpod/export', 'Devices\\BodpodController@export');
    Route::resource('bodpod', 'Devices\\BodpodController');
    Route::post('customfields/{id}', 'CustomFields\\CustomFieldController@update');
    Route::resource('customfields', 'CustomFields\\CustomFieldController');
});



// Route::post('mbca', 'Devices\MbcaController@import');
