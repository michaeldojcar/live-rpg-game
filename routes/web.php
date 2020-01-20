<?php

Route::get('/', 'IndexController@index')->name('index');

// Role mobile show
Route::get('/role/{id}', 'RoleController@show')->name('role.show');

// Operator dashboard
Route::get('/operator', 'OperatorController@index')->name('index');
