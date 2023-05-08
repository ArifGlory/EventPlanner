<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            'list user',
            'edit user',
            'delete user',
            'create user',
            'settings',
        ];

        foreach ($datas as $key => $value) {
            $permission = Permission::updateOrCreate(
                [
                    'name' => $value
                ],
                [
                    'name' => $value,
                    'guard_name'    => 'web',
                ]
            );
        }
    }
}
