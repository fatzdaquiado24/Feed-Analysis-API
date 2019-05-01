<?php

use Illuminate\Http\Request;

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

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::get('verify/{token}', 'AuthController@verify');

Route::group(['middleware' => ['api', 'multiauth:client,head manager']], function () {
    Route::post('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
    Route::resource('chemical-tests', 'ChemicalTestController')->only('index');
    Route::resource('appointment-dates', 'AppointmentDateController')->only('index');
});

Route::group(['middleware' => ['api', 'multiauth:head manager']], function () {
    Route::resource('chemical-tests', 'ChemicalTestController')->except('index');
    Route::resource('clients', 'ClientController')->except(['store']);
    Route::apiResource('chemists', 'ChemistController');
    Route::apiResource('receivers', 'ReceiverController');
    Route::resource('appointment-dates', 'AppointmentDateController')->except('index');
});

Route::group(['middleware' => ['api', 'multiauth:client']], function () {
});