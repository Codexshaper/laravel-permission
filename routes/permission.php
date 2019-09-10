<?php

Route::group(['namespace' => config('permission.controller_namespace'),'middleware'=>['role:admin']],function(){
	// Permissions
	Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
	Route::get('/asset', 'PermissionController@assets')->name('permission.asset');

	// Users
	Route::get('/users', 'UserController@index')->name('users');
	// Vue CRUD
	Route::get('/users/all', 'UserController@all')->name('users.all');
	Route::get('/user/{id}', 'UserController@getUser')->name('user');
	Route::post('/user/add', 'UserController@addUser')->name('user.add');
	// Route::get('/user/edit/', 'UserController@editUser')->name('user.edit');
	Route::put('/user/update/', 'UserController@updateUser')->name('user.update');
	Route::delete('/user/delete/{id}', 'UserController@deleteUser')->name('user.delete');
	// Ajax
	Route::get('/roles/all', 'UserController@allRoles')->name('roles.all');
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
