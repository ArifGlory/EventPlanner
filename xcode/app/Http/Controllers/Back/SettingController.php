<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Services\SettingService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    //
    private $settingService;

    public function __construct()
    {
       // $this->middleware(['auth', 'cekadmin']);
        $this->settingService = new SettingService();
    }

    public function index()
    {
        $view = 'mypanel.setting.index';
        $data = [
            'data' => Settings::select(['setting_var', 'setting_val', 'setting_name', 'setting_type', 'setting_description'])->orderBy('id','ASC')->get(),
        ];
        return view($view, $data);
    }

    public function updateAll()
    {
        $settings = Settings::all();

        DB::beginTransaction();
        try {
            $this->settingService->update($settings, \request()->all());

        } catch (QueryException $e) {
            $msgerror = $e->getMessage() ?? 'pengaturan aplikasi gagal disimpan';
            DB::rollBack();
            return res500(\request()->ajax(), $msgerror);
        } catch (ValidationException $e) {
            $msgerror = $e->getMessage() ?? 'pengaturan aplikasi gagal disimpan';
            DB::rollBack();
            return res500(\request()->ajax(), $msgerror);
            //return back()->withErrors($e->validator)->withInput();
        }
        Cache::forget('settings');
        $msgsuccess = 'pengaturan aplikasi berhasil disimpan';
        DB::commit();
        return res200(\request()->ajax(), $msgsuccess);
    }
}
