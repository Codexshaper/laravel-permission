<?php
namespace CodexShaper\Permission\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface Role
{
    public function permissions(): BelongsToMany;
}