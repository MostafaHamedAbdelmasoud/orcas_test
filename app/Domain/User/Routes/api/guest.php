<?php

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



Route::group(['middleware' => 'guest:api'], function () {
    ###CRUD_PLACEHOLDER###
    Route::post('login', 'Auth\LoginController@login');

    Route::get('users/index','UserController@index')->name('users.index');
});
