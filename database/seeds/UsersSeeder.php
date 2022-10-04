<?php

use CodexShaper\Permission\Models\Role;
use CodexShaper\Permission\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name  = "Admin";
        $user->email = "admin@admin.com";
        $user->password = Hash::make("123456789");
        $user->save();
        $user->assignRoles('admin,manager,user');
        // $admin->role()->updateExistingPivot($admin_role, ['created_at'=>now(),'updated_at'=>now()]);
    }
}
