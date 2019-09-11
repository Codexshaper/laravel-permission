<?php

Route::group(['namespace' => config('permission.controller_namespace'),'middleware'=>['role:admin']],function(){
	// Asset
	Route::get('/asset', 'PermissionController@assets')->name('permission.asset');
	// Test
	Route::get('/laravel-permission', 'PermissionController@doc')->name('permission.doc');
});
