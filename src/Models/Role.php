<?php

namespace CodexShaper\Permission\Models;
use CodexShaper\Permission\Contracts\Role as RoleContract;
use CodexShaper\Permission\Models\Permission;
use CodexShaper\Permission\Models\User;
use CodexShaper\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model implements RoleContract
{
    use HasPermissions;

	protected $fillable = [
        'name', 'slug',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class,'permission_role','role_id','permission_id');
    }
    
	public function users(){
        return $this->belongsToMany(User::class,'role_users','role_id','user_id');
    }
}