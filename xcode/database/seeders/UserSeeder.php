<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrNew([
            'username' => 'superadmin',
            'email' => 'superadmin@gmail.com',

        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('123456'),
            'is_active' => 1,

        ]);
        $user->save();

        $role = Role::firstOrNew([
            'guard_name'    => 'web',
            'name'          => 'superadmin'
        ]);
        $role->save();


        $this->call([
            PermissionSeeder::class
        ]);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);
        $user->assignRole($role);

        $newRoles = ['superadmin', 'user'];

        foreach ($newRoles as $key => $value) {
            Role::firstOrNew([
                'guard_name'    => 'web',
                'name'          => $value
            ]);
        }
    }
}
