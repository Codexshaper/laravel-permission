<?php

Route::group(['namespace' => config('permission.controller_namespace'),'middleware'=>['role:admin']],function(){
	Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
	Route::get('/asset', 'PermissionController@assets')->name('permission.asset');

	Route::get('getRoles/{id}', 'PermissionController@getRoles');

	// Ajax
	Route::post('/role/add', 'PermissionController@addRole')->name('role.add');
	Route::get('/role/{id}', 'PermissionController@getRole')->name('role.get');
	Route::put('/role/update', 'PermissionController@updateRole')->name('role.edit');
	Route::delete('/role/delete', 'PermissionController@deleteRole')->name('role.delete');

	// Permission
	Route::post('/permission/add', 'PermissionController@addPermission')->name('permission.add');
	Route::get('/permission/{id}', 'PermissionController@getPermission')->name('permission.get');
	Route::put('/permission/update', 'PermissionController@updatePermission')->name('permission.edit');
	Route::delete('/permission/delete', 'PermissionController@deletePermission')->name('permission.delete');
});