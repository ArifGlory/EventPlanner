<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileRequest;
use App\Models\Member;
use App\Models\User;
use App\Services\hideyoriService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;


class ProfileController extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->myService = new hideyoriService();
    }

    public function profil()
    {
        $view = 'mypanel.user.profil.index';
        $data = [
            'row' => Auth::user(),
        ];
        return view($view, $data);
    }

    public function updateProfil(ProfileRequest $request)
    {
        $master = $this->myService->find(User::class, Auth::user()->id);
        $requestData = $request->all();
        if ($master) {
            $avatar = $master->foto;
            if ($request->hasFile('foto')) {
                $avatar = StoreFileWithFolder($request->file('foto'), 'public', 'user', ['replace' => $master->foto]);
            } else {
                if (isset($request->remove_avatar)) {
                    removeFileFolder('public', $master->foto);
                    $avatar = null;
                }
            }

            $dataMember = [
              'foto' => $avatar
            ];
            $this->myService->update($master, $dataMember);
            unset($requestData['foto']);
           // updateData($master, $dataMember, 'profil', false);
        }
        return updateData($master, $requestData, 'profil');


    }


    public function ubahPassword()
    {
        $view = 'mypanel.user.ubahpw.index';
        $data = [
            'row' => Auth::user(),
        ];
        return view($view, $data);
    }

    public function updatePassword(Request $request)
    {
        if (!Hash::check($request->input('old_password'), auth()->user()->password)) {
            $error['old_password'] = 'Password lama anda salah';
            return back()->withInput()->withErrors($error);
        }

        $this->validate($request, [
            'password' => 'required|confirmed'
        ]);

        $master = $this->myService->find(User::class, auth()->id());
        if (isset($request['password'])) {
            $password = Hash::make($request['password']);
        }
        $requestData['password'] = $password;
        saveLogs($master, 'password', 'password ' . $master->name . ' updated', 'updated', $master);
        return updateData($master, $requestData, 'password');
    }

    public function logSaya()
    {
        $view = 'mypanel.user.aktivitas.index';
        $data = [
            'row' => Auth::user(),
        ];
        return view($view, $data);
    }

    public function logsDataSaya(Request $request, $id)
    {
        $idnya = decodeId($id) ?? Auth::user()->id;
        if ($request->ajax()) {
            $dataLogs = Activity::where('log_name', 'gudang_ternak')->where('causer_id', $idnya)->latest()->paginate(10);
            $data = [
                "list" => $dataLogs
            ];
            return view('mypanel.user.aktivitas.data', $data)->render();
        }
        return false;
    }

    public function logsHeader(Request $request)
    {
        if ($request->ajax()) {

            $dataLogs = Activity::where('log_IdUser', Auth::user()->id)->orderByDesc('log_Time')->skip(0)->take(5)->get();
            $data = [
                "listLog" => $dataLogs
            ];
            return view('mypanel.layout.renderlog', $data)->render();
        } else {
            return false;
        }
    }


}
