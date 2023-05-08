<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;


class LogController extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['adminaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'aktivitas';
    }

    public function index()
    {
        $listUserLog = Activity::pluck('causer_id')->toArray();
        $eloUser = User::whereIn('id_users', $listUserLog)->leftJoin('ktp', 'ktp.nik', '=', 'users_login.nik')->orderBy('nama', 'ASC')->pluck('id_users','nama')->all();
        $view = 'mypanel.aktivitas.index';
        $data = [
            'listUser' => $eloUser,
        ];
        return view($view, $data);
    }

    public function data(Request $request)
    {
        $data = Activity::where('log_name', 'gudang_ternak')->leftJoin('users_login', 'users_login.id_users', '=', 'activity_log.causer_id')
            ->leftJoin('ktp', 'ktp.nik', '=', 'users_login.nik')
            ->select('activity_log.id as id', 'activity_log.created_at as created_at', 'description', 'ktp.nama as name');

        $causer_id = $request->get('causer_id');
        if ($causer_id != '') :
            $data->whereIn('causer_id', $causer_id);
        endif;

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
                return checkboxRowDT($row->id);
            })
            ->editColumn('description', function ($row) {
                return change_event_name($row->description);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? TanggalIndowaktu($row->created_at) : '';
            })

            ->escapeColumns([])
            ->toJson();
    }

    public function destroy($id)
    {
        $this->authorize('destroy');
        return destroyData(Activity::class, $id, $this->context);
    }

    public function bulkDelete()
    {
        $this->authorize('destroy');
        return destroyBulk(Activity::class, \request()->id, $this->context);
    }

}
