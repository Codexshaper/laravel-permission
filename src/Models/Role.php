<?php

namespace CodexShaper\Permission\Models;
use Illuminate\Database\Eloquent\Model;
use CodexShaper\Permission\Models\User;
use CodexShaper\Permission\Models\Permission;

class Role extends Model
{
	protected $fillable = [
        'name', 'slug',
    ];
    
	public function users(){
        return $this->belongsToMany(User::class,'role_users','role_id','user_id');
    }

    public function permissions()
    {
    	return $this->belongsToMany(Permission::class,'permission_role','role_id','permission_id');
    }
}