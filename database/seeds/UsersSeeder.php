<?php

use CodexShaper\Permission\Models\Role;
use CodexShaper\Permission\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::where('slug','admin')->first();
        $user = new User;
        $user->name  = "Admin";
        $user->email = "admin@admin.com";
        $user->password = Hash::make("123456");
        $user->save();
        $user->roles()->attach($admin_role,['created_at'=>now(),'updated_at'=>now()]);
        // $admin->role()->updateExistingPivot($admin_role, ['created_at'=>now(),'updated_at'=>now()]);
    }
}
