<?php

use CodexShaper\Permission\Models\Permission;
use CodexShaper\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = Role::create([

        	'name' 			=> 'Super Admin',
        	'slug' 			=> 'admin',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);
        $admin->assignPermissions([
            'browse',
            'read',
            'edit',
            'add',
            'delete'
        ]);

        $manager = Role::create([

        	'name' 			=> 'Manager',
        	'slug' 			=> 'manager',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ])->assignPermissions([
            'browse',
            'read',
            'edit',
            'add',
        ]);

        $user = Role::create([

        	'name' 			=> 'User',
        	'slug' 			=> 'user',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ])->assignPermissions([
            'browse',
            'read',
        ]);
    }
}
