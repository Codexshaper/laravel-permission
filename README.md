# laravel-permission
Laravel Multi Authentication

# Note : Before Install and use this package run below command
Before Laravel version 6.0
```
php artisan make:auth
```
From Laravel Version 6.0

```
1. composer require laravel/ui
2. php artisan ui vue --auth
3. npm install
4. npm run dev
```

# Install the Package

```
composer require codexshaper/laravel-permission
```
# Publish Resource, Configs, Migration and Seeding Database in a single command

```
php artisan permission:install
```
# Or Publish Resource, Configs, Migration and Seeding Database Manually
1. Publish Configs
```
php artisan vendor:publish --tag=permission.config
```
2. Publish Seeds
```
php artisan vendor:publish --tag=permission.seeds
```
3. Migrate Database
```
php artisan migrate
```
4. Run composer dump autoload
```
composer dump-autoload
```
5. Seeding Database
```
php artisan db:seed --class=PermissionDatabaseSeeder
```
6. Add Routes
```
Route::group(['prefix' => config('permission.prefix')], function () {
    Permission::routes();
});
```
#Import `use CodexShaper\Permission\Traits\HasRoles` or simply `use HasRoles` Trait into your `App\User` Model
```
namespace App;

use CodexShaper\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```
#Check Permission go to ```/admin/laravel-permission```

# Install Demo
```
php artisan permission:install:demo
```
##Demo link ```/admin/permissions```

#Publish ```Views```
```
php artisan permission:publish:views
```

#Publish ```Resources```
```
php artisan permission:publish:resources
```
#For Overriding Views and Resources, Change your config file ```/config/permission.php```
```
'resources_path' => 'resources/views/vendor/permissions/assets',
'views' => 'resources/views/vendor/permissions/views',
```
# Permission
```
use CodexShaper\Permission\Models\Permission;

$permission = Permission::create([
	'name' 	=> 'Browse',
	'slug' 	=> slug('browse'),
	'created_at' => now(),
	'updated_at' => now(),
]);
```

#Give Permission to Roles
```
// Create Role before set permission
// $roles = [role_slug_or_id] ex: ['admin',1,2,'author']
$permission->givePermissionToRoles( $roles );
```
#Update permission roles
```
$role_ids = [1,3,5]
$permission->syncPermissionToRoles( $role_ids );
```
#Delete permission roles
```
// Delete specific Roles
$role_ids = [1,3,5];
$permission->revokePermissionsFromRoles( $role_ids );
// Delete all roles for current permission
$permission->revokePermissionsFromRoles();
```
# Role
```
use CodexShaper\Permission\Models\Role;

$admin = Role::create([
	'name' 	=> 'Super Admin',
	'slug' 	=> 'admin',
	'created_at' => now(),
	'updated_at' => now(),
]);
```
#Assign Permission
```
$admin->assignPermissions([
    'browse',
    'read',
    'edit',
    'add',
    'delete'
]);
```
#Update Permission
```
$permission_ids = [1,3,5]
$admin->syncPermissions( $permission_ids );
```
#Delete permission
```
// Delete specific Permissions
$permission_ids = [1,3,5];
$admin->revokePermissions( $permission_ids );
// Delete all roles for current roles
$admin->revokePermissions();
```
#Check Permission
```
$admin->hasPermission( $permission_slug );
```
# User
```
use App\User;

$user = new User;
$user->name = 'John Doe';
$user->email = 'john@gmail.com';
$user->password = Hash::make('password');
$user->save();
$user->assignRoles('admin');
```
#Assign Roles into existing user
```
$user = User::find(1);
$user->assignRoles('admin');
```
#Assign Multiple roles
```
$user = User::find(1);
// Use pipe(|)
$user->assignRoles('admin|client|customer');
// Or use comma(,)
$user->assignRoles('admin,client,customer');
// Or use space
$user->assignRoles('admin client customer');
// Or Mixed
$user->assignRoles('admin client,customer|write');
// Pass custom separators
$separators =  ',.| ';
$user->assignRoles('admin client,customer|write', $separators);
```
#Update Roles
```
$role_ids = [1,2,3];
$user->syncRoles( $role_ids );
```
#Delete Roles
```
// Delete specific Roles for current User
$role_ids = [1,3,5];
$user->revokeRoles( $role_ids );
// Delete all roles for current user
$user->revokeRoles();
```
#Check Role
```
$user->hasRole( $role_slug );
```
# Add Middleware on route
```
Route::group(['middleware'=>['role:admin']],function(){
	// Routes
});
```

# View Directories
```
@can('browse')
<p>You Can Browse</p>
@endcan

@role('admin')
<p>You are admin</p>
@endrole

@hasrole('admin')
<p>You have admin Permission</p>
@endhasrole

@haspermission('edit')
<p>You have admin Permission</p>
@endhaspermission
```