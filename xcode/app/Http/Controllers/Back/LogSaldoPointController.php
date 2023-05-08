<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\LogSaldoPoint;
use App\Models\User;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;


class LogSaldoPointController extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['adminaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'log_saldo';
    }

    public function index()
    {
       /* $listUserLog = Activity::pluck('causer_id')->toArray();
        $eloUser = User::whereIn('id_users', $listUserLog)->leftJoin('ktp', 'ktp.nik', '=', 'users_login.nik')->orderBy('nama', 'ASC')->pluck('id_users','nama')->all();*/
        $eloUser = User::where('level','!=','superadmin')
            ->get();
        $view = 'mypanel.log_saldo.index';
        $data = [
            'listUser' => $eloUser,
        ];
        return view($view, $data);
    }

    public function data(Request $request)
    {
        $data = LogSaldoPoint::leftJoin('users', 'users.id', '=', 'log_saldo_point.user_id')
            ->orderBy('log_saldo_point.log_saldo_id',"DESC")
            ->select('log_saldo_point.*', 'users.name');

        $user_id = $request->get('user_id');
        if ($user_id != '') :
            $data->where('log_saldo_point.user_id', $user_id);
        endif;

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
                return checkboxRowDT($row->log_saldo_id);
            })
            ->editColumn('log_saldo_description', function ($row) {
                return change_event_name($row->log_saldo_description);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? TanggalIndowaktu($row->created_at) : '';
            })
            ->editColumn('log_saldo_nominal', function ($row) {
                return $row->log_saldo_nominal ? format_angka_indo($row->log_saldo_nominal) : '';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->log_saldo_id, 'main/transaksi-point/detail');
                $izin .= $aksiDetail;

                return aksiButton($izin);
            })
            ->escapeColumns([])
            ->toJson();
    }

    public function form(){

        $data = [
            'mode' => 'add',
            'action' => url('main/transaksi-point/create'),
            'id' => '',
            'log_saldo_id' => old('log_saldo_id', ''),
            'user_id' => old('user_id', ''),
            'log_saldo_nominal' => old('log_saldo_nominal', ''),
            'log_saldo_status' => old('log_saldo_status', ''),
            'log_saldo_description' => old('log_saldo_description', ''),
            'log_saldo_bukti' => old('log_saldo_bukti', ''),

        ];
        $view = 'mypanel.log_saldo.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'user_id' => 'required',
            'log_saldo_nominal' => 'required',
            'log_saldo_description' => 'required',
            'log_saldo_bukti' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'user_id' => 'Pengguna',
            'log_saldo_nominal' => 'Nominal Top-up',
            'log_saldo_description' => 'desrkipsi top up',
            'log_saldo_bukti' => 'bukti pembayaran',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;
        $requestData['log_saldo_status'] = "deposit";
        $requestData['log_saldo_jenis_topup'] = "manual";

        if ($request->hasFile('log_saldo_bukti')) {
            $requestData['log_saldo_bukti'] = StoreFileWithFolder($request->file('log_saldo_bukti'), 'public', 'log_saldo');
        }
        //ubah saldo pengguna nya
        $user = User::find($requestData['user_id']);
        $new_saldo = $user->saldo_point + $requestData['log_saldo_nominal'];
        $data_update = array(
            'saldo_point' => $new_saldo
        );
        $user->update($data_update);



        return storeData(LogSaldoPoint::class, $requestData, $this->context, true, 'main/transaksi-point');
    }

    public function show($id)
    {
        $master = LogSaldoPoint::leftJoin('users', 'users.id', '=', 'log_saldo_point.user_id')
            ->select('log_saldo_point.*', 'users.name')
            ->where('log_saldo_id',decodeId($id))
            ->first();

        $data =
            [
                'row' => $master,

            ];
        $view = 'mypanel.log_saldo.show';
        return view($view, $data);
    }


}
