<?php
namespace CodexShaper\Permission\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Permission
{
    public function permission_roles(): BelongsToMany;
}