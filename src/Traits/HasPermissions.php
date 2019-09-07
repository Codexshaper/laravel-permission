<?php

namespace CodexShaper\Permission\Traits;

use CodexShaper\Permission\Models\Permission;
use CodexShaper\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissions
{
	public function roles(): BelongsToMany
	{
        return $this->belongsToMany(Role::class,'role_users','user_id','role_id');
    }

    public function givePermissionToRoles( array $roles )
    {
    	foreach ($roles as $role) {
    		$role = $this->getRole( $role );
        	if( $role ) {
        		$this->permission_roles()->attach([
	                $role->id => [
	                    'created_at'=>now(),
	                    'updated_at'=>now()
	                ],
	            ]);
        	}
    	}
    }

    public function syncPermissionToRoles( array $ids )
    {
    	return $this->permission_roles()->sync($ids);
    }

    public function revokePermissionsFromRoles( array $ids = [] )
    {
    	if( empty( $ids ) ) {
    		return $this->permission_roles()->detach();
    	}
    	return $this->permission_roles()->detach($ids);
    }

	public function assignPermissions( array $breads ) {
        foreach ($breads as $bread) {
        	$permission = $this->getPermission($bread);
        	if( $permission ) {
        		$this->permissions()->attach([
	                $permission->id => [
	                    'created_at'=>now(),
	                    'updated_at'=>now()
	                ],
	            ]);
        	}
        }
    }

    public function updatePermissions( array $ids )
    {
    	return $this->permissions()->sync($ids);
    }

    public function syncPermissions( array $ids )
    {
    	return $this->permissions()->sync($ids);
    }

    public function revokePermissions( array $ids = [] )
    {
    	if( empty( $ids ) ) {
    		return $this->permissions()->detach();
    	}
    	return $this->permissions()->detach($ids);
    }

    public function hasPermission($privilege)
    {
        foreach( $this->roles as $role ) {
            foreach ( $role->permissions as $permission ) {
                if ($permission->slug == $privilege) {
                    return true;
                }
            }  
        }

        return false;
    }

    protected function getPermission( $permission ){
    	if( is_numeric( $permission ) ) {
    		return Permission::find( (int)$permission );
    	}elseif( is_string( $permission ) ){
    		return Permission::where('slug', $permission)->first();
    	}

    	return false;
    }

    public function getRole( $role ) {
        if( is_numeric($role) ) {
            return Role::find( (int)$role );
        }elseif( is_string( $role ) ) {
            return Role::where('slug', slug($role))->first();

        }
    }
}