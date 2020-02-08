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

Route::get('/role/{role_id}/person/color_1/{c1}/color_2/{c2}/color_3/{c3}', 'PersonController@show');
Route::post('/role/{role_id}/telemetries', 'PersonController@telemetries');

Route::get('/roles', 'RoleController@index');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
