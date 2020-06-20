<?php

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

/*
 * NPC role routes
 */
Route::get('/role/{role_id}/person/color_1/{c1}/color_2/{c2}/color_3/{c3}', 'RoleInterfaceController@show');
Route::post('/role/{role_id}/telemetries', 'RoleInterfaceController@telemetries');

Route::post('/role/{role}/quest/{quest}/pending', 'RoleInterfaceController@setPending');
Route::post('/role/{role}/quest/{quest}/done', 'RoleInterfaceController@setDone');
Route::post('/role/{role}/quest/{quest}/failed', 'RoleInterfaceController@setFailed');


/*
 * Operator API routes
 */
Route::get('/overview', 'OperatorController@overview');
Route::get('/map', 'RoleController@mapIndex');

Route::apiResource('roles', 'RoleController');
Route::apiResource('players', 'PlayerController');
Route::apiResource('groups', 'GroupController');

Route::resource('quests', 'QuestController');
Route::post('/quests/{id}/sub-quest', 'QuestController@storeSubQuest');

Route::post('/options/admin_message', 'OptionController@storeMessage');
Route::get('/options', 'OptionController@index');

Route::resource('quest_groups', 'QuestGroupController');
