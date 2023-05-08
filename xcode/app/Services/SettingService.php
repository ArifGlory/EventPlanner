<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Support\Facades\Validator;

class SettingService
{
    public function update($settings, $data)
    {
        foreach ($settings as $st) {
            if (isset($data[$st->setting_var])) {
                if ($st->setting_type == 'file') {
                    $validator = Validator::make($data, [
                        $st->setting_var => 'sometimes|mimes:' . permission_image() . '|max:' . max_upload_image(),
                    ]);
                    if ($validator->fails()) {

                        throw $validator->validated();
                    }


                    if (isset($data[$st->setting_var])) {
                        $data[$st->setting_var] = StoreFileWithFolder($data[$st->setting_var], 'public', 'setting');
                    }

                }
                $setting = Settings::where('setting_var', $st->setting_var)->first();
                $setting->setting_val = $data[$st->setting_var];
                $setting->save();

            }
        }
        saveLogs($setting, 'gudang_ternak', 'konfigurasi aplikasi gudang ternak telah diubah', 'updated', $setting);
        return true;
    }
}
