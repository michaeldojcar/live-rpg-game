<?php


Route::get('/', 'IndexController@index')->name('index');

// Role mobile show
Route::get('/role/{id}', 'RoleInterfaceController@index')->name('role.show');

// Operator dashboard
Route::get('/operator', 'OperatorController@index')->name('operator');
