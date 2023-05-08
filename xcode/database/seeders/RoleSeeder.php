<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $datas = [
            'superadmin',
            'admin',
            'user',
        ];

        foreach ($datas as $key => $value) {
            $permission = Role::updateOrCreate(
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
