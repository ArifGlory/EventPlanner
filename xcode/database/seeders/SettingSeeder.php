<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
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
            [
                'setting_name' => 'Nama Aplikasi',
                'setting_var' => 'app_name',
                'setting_val' => 'Ulti',
                'setting_type' => 'text',
                'setting_desc' => 'Silahkan isi nama aplikasi anda dengan benar.',
            ],
            [
                'setting_name' => 'Logo Aplikasi',
                'setting_var' => 'app_logo',
                'setting_val' => null,
                'setting_type' => 'file',
                'setting_desc' => 'Silahkan upload logo aplikasi anda dengan benar.',
            ],
            [
                'setting_name' => 'Author Aplikasi',
                'setting_var' => 'app_author',
                'setting_val' => null,
                'setting_type' => 'text',
                'setting_desc' => 'Silahkan isi author aplikasi anda dengan benar.',
            ],
            [
                'setting_name' => 'Versi Aplikasi',
                'setting_var' => 'app_version',
                'setting_val' => null,
                'setting_type' => 'text',
                'setting_desc' => 'Silahkan isi versi aplikasi anda dengan benar.',
            ],
            [
                'setting_name' => 'Favicon Aplikasi',
                'setting_var' => 'app_favicon',
                'setting_val' => null,
                'setting_type' => 'file',
                'setting_desc' => 'Silahkan isi favicon aplikasi anda dengan benar.',
            ],

            [
                'setting_name' => 'Deskripsi Aplikasi',
                'setting_var' => 'app_description',
                'setting_val' => null,
                'setting_type' => 'text',
                'setting_desc' => 'Silahkan isi deskripsi aplikasi anda dengan benar.',
            ],

            [
                'setting_name' => 'Keyword Aplikasi',
                'setting_var' => 'app_keyword',
                'setting_val' => null,
                'setting_type' => 'text',
                'setting_desc' => 'Silahkan isi keyword aplikasi anda dengan benar.',
            ],

            [
                'setting_name' => 'Author Aplikasi',
                'setting_var' => 'app_author',
                'setting_val' => null,
                'setting_type' => 'text',
                'setting_desc' => 'Silahkan isi Author aplikasi anda dengan benar.',
            ],
        ];

        foreach ($datas as $key => $value) {
            Settings::updateOrCreate(
                [
                    'setting_var' => $value['setting_var']
                ],
                [
                    "setting_name" => $value['setting_name'],
                    "setting_val" => $value['setting_val'],
                    "setting_type" => $value['setting_type'],
                    "setting_description" => $value['setting_desc'],
                ]
            );
        }
    }
}
