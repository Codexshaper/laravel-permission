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

        	'name' 			=> 'Add Task',
        	'slug' 			=> str_slug('add task'),
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Permission::create([

        	'name' 			=> 'Edit Task',
        	'slug' 			=> str_slug('edit task'),
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);

        Permission::create([

        	'name' 			=> 'Delete Task',
        	'slug' 			=> str_slug('delete task'),
        	'created_at' 	=> now(),
        	'updated_at' 	=> now(),
        ]);
    }
}
