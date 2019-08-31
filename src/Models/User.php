<?php

namespace CodexShaper\Permission\Models;

use CodexShaper\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;

}