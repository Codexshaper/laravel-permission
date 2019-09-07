<?php

namespace CodexShaper\Permission\Traits;

use CodexShaper\Permission\Models\Role;
use CodexShaper\Permission\Traits\HasPermissions;

trait HasRoles
{
    use HasPermissions;
    
    public function hasRole($permission)
    {
        foreach($this->roles as $role) {
            if ($role->slug == $permission) {
                return true;
            }
        }

        return false;
    }

    public function assignRoles( $roles, $separators =  ',.|' ) {
        if( is_string( $roles ) ) {
            $pattern = '/['.$separators.']/';
            $roles = str_spliter($roles, $pattern);
        }

        foreach ($roles as $role) {
            $this->roles()->attach(
               $this->getRole($role),
               [
                   'created_at'=>now(),
                   'updated_at'=>now()
               ]);
        }
    }
}