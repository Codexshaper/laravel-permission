<?php

return [
	'prefix' => 'admin',
	'namespace' => '\CodexShaper\Permission',
	'controller_namespace' => '\CodexShaper\Permission\Http\Controllers',
    'models' => [
        'permission' => CodexShaper\Permission\Models\Permission::class,
        'role' => CodexShaper\Permission\Models\Role::class,
    ],
    'table_names' => [
        'roles' => 'roles',
        'role_users' => 'role_users',
        'permissions' => 'permissions',
        'permission_role' => 'permission_role',
    ],
    'resources_path' => 'vendor/codexshaper/laravel-permission/resources/assets/',

];