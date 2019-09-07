<?php

namespace CodexShaper\Permission\Models;

use CodexShaper\Permission\Traits\HasRoles;
use CodexShaper\Permission\Contracts\User as UserContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements UserContract
{
    use HasRoles;

}