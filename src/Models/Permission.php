<?php

namespace CodexShaper\Permission\Models;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $fillable = [
        'name', 'slug',
    ];
}