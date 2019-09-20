<?php

Route::group(['namespace' => config('permission.controller_namespace')],function(){
	// Asset
	Route::get('/asset', 'PermissionController@assets')->name('permission.asset');
	// Test
	Route::get('/laravel-permission', 'PermissionController@doc')->name('permission.doc');
});
