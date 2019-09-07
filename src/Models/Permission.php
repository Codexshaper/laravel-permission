<?php

namespace CodexShaper\Permission\Models;
use CodexShaper\Permission\Contracts\Permission as PermissionContract;
use CodexShaper\Permission\Models\Role;
use CodexShaper\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model implements PermissionContract
{
	use HasRoles;

	protected $fillable = [
        'name', 'slug',
    ];

    public function permission_roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'permission_role','permission_id','role_id');
    }
}