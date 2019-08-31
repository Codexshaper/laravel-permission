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
        $add = Permission::where('slug','add-task')->first();
        $edit = Permission::where('slug','edit-task')->first();
        $delete = Permission::where('slug','delete-task')->first();

        $admin = Role::create([

        	'name' 			=> 'Super Admin',
        	'slug' 			=> 'admin',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);
        $admin->permissions()->attach([
            $add->id => [
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            $edit->id => [
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            $delete->id => [
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        $manager = Role::create([

        	'name' 			=> 'Manager',
        	'slug' 			=> 'manager',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);
        $manager->permissions()->attach([
            $edit->id => [
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);

        $writer = Role::create([

        	'name' 			=> 'Writer',
        	'slug' 			=> 'writer',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        $client = Role::create([

        	'name' 			=> 'Client',
        	'slug' 			=> 'client',
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);
        $client->permissions()->attach([
            $add->id => [
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            $edit->id => [
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ]);
    }
}
