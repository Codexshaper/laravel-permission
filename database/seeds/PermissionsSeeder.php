<?php

use CodexShaper\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Permission::create([

        	'name' 			=> 'Browse',
        	'slug' 			=> slug('browse'),
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Permission::create([

        	'name' 			=> 'Read',
        	'slug' 			=> slug('read'),
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Permission::create([

        	'name' 			=> 'Edit',
        	'slug' 			=> slug('edit'),
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Permission::create([

            'name'          => 'Add',
            'slug'          => slug('add'),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        Permission::create([

            'name'          => 'Delete',
            'slug'          => slug('delete'),
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}
