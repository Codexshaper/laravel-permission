<?php

namespace CodexShaper\Permission;

class Permission
{
	
	public function __construct(){}

	public function routes() {
		require __DIR__.'/../routes/permission.php';
	}
}