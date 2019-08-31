<?php

namespace CodexShaper\Permission\Traits;

use CodexShaper\Permission\Models\Role;

trait HasRoles
{
	public function roles(){
        return $this->belongsToMany(Role::class,'role_users','user_id','role_id');
    }
	
	public function hasRole($permission)
    {
        foreach($this->roles as $role) {
            if ($role->slug == $permission) {
                return true;
            }
        }

        return false;
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
}