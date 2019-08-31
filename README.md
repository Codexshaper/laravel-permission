# laravel-permission
Laravel Multi Authentication

#Install the Package

```
composer require codexshaper/laravel-permission
```
#Publish Resource, Configs, Migration and Seeding Database in a single command

```
php artisan permission:install
```
#Or Publish Resource, Configs, Migration and Seeding Database Manually
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
4. Seeding Database
```
php artisan db:seed --class=PermissionDatabaseSeeder
```
#Import `use CodexShaper\Permission\Traits\HasRoles` or simply `use HasRoles` Trait into your `App\User` Model

#Example
```
namespace App;

use HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
}
```
#Applly Rules on Route

```
Route::group(['middleware'=>['role:admin|manager']],function(){
	Route::get('/permissions', function(){
		return "Permission Working";
	});
});
```

# Note : Before Install and use this package run below command

```
php artisan make:auth
```
