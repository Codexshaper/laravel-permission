<?php
namespace CodexShaper\Permission\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface User
{
    public function roles(): BelongsToMany;
}