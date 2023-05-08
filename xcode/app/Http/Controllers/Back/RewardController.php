<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\Store;
use App\Models\LogSaldoPoint;
use App\Models\Mission;
use App\Models\Reward;
use App\Models\User;
use App\Models\Product;
use App\Models\Stores;
use App\Models\SubCategory;
use App\Models\Submission;
use App\Models\Voucher;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;


class RewardController  extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['adminaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'reward';
    }

    public function index()
    {
        $view = 'mypanel.reward.index';

        $data = [

        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        $data = Reward::get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
               /* $izin = '<i class="fas fa-ellipsis-h"></i>';
               if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin = checkboxRowDT($row->reward_id);
                }*/
                $izin = checkboxRowDT($row->reward_id);
                return $izin;
            })
            ->editColumn('reward_point_condition', function ($row) {
                return $row->reward_point_condition ? format_angka_indo($row->reward_point_condition) : '';
            })
            ->editColumn('reward_status', function ($row) {
                $status = "";
                if ($row->reward_status == 1){
                    $info = '<h6><span class="badge badge-primary">Aktif</span></h6>';
                    $status .=$info;
                }else{
                    $info = '<h6><span class="badge badge-warning">Non-Aktif</span></h6>';
                    $status .=$info;
                }
                return $status;
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->reward_id, 'main/reward/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->reward_id, 'main/reward/edit');
                $aksiHapus = deleteButtonDT($row->reward_id, 'deleteDataTable','reward/delete');

                $izin .= $aksiEdit;
                $izin .= $aksiHapus;
                /*if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin .= $aksiEdit;
                }
                if (cekRoleAkses('superadmin') == true){
                    $izin .= $aksiHapus;
                }*/

                return aksiButton($izin);
            })
            ->escapeColumns([])
            ->toJson();
    }


    public function form()
    {
        $data = [
            'mode' => 'add',
            'action' => url('main/reward/create'),
            'id' => '',
            'reward_name' => old('reward_name', ''),
            'reward_point_condition' => old('reward_point_condition', ''),
            'reward_status' => old('reward_status', ''),
            'reward_description' => old('reward_description', ''),
            'reward_image' => old('reward_image', ''),

        ];
        $view = 'mypanel.reward.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'reward_name' => 'required',
            'reward_point_condition' => 'required',
            'reward_status' => 'required',
            'reward_description' => 'required',
            'reward_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'reward_name' => 'nama',
            'reward_point_condition' => 'syarat point yang dibutuhkan',
            'reward_status' => 'status reward',
            'reward_description' => 'deskripsi ',
            'reward_image' => 'foto reward',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;


        if ($request->hasFile('reward_image')) {
            $requestData['reward_image'] = StoreFileWithFolder($request->file('reward_image'), 'public', 'reward');
        }


        return storeData(Reward::class, $requestData, $this->context, true, 'main/reward');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Reward::class, decodeId($id));

        $data =
            [
                'mode' => 'edit',
                'action' => url('main/reward/update/' . $id),
                'id' => $id,
                'reward_name' => old('reward_name', $master->reward_name),
                'reward_point_condition' => old('reward_point_condition', $master->reward_point_condition),
                'reward_status' => old('reward_status', $master->reward_status),
                'reward_description' => old('reward_description', $master->reward_description),
                'reward_image' => old('reward_image', $master->reward_image),
            ];

        $view = 'mypanel.reward.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Reward::class, decodeId($id));

        $rule = [
            'reward_name' => 'required',
            'reward_point_condition' => 'required',
            'reward_status' => 'required',
            'reward_description' => 'required',
            //'reward_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'reward_name' => 'nama',
            'reward_point_condition' => 'syarat point yang dibutuhkan',
            'reward_status' => 'status reward',
            'reward_description' => 'deskripsi ',
            //'reward_image' => 'foto reward',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        $gambar = $master->reward_image;
        if ($request->hasFile('reward_image')) {
            $gambar = StoreFileWithFolder($request->file('reward_image'), 'public', 'reward', ['replace' => $master->reward_image]);
        } else {
            if (isset($request->remove_gambar)) {
                removeFileFolder('public', $master->reward_image);
                $gambar = null;
            }
        }
        $requestData['reward_image'] = $gambar;

        return updateData($master, $requestData, $this->context, true, 'main/reward');
    }

    public function updateStatus(Request $request)
    {

    }

    public function bulkStatus(Request $request)
    {

       /* $id = $request->id;
        $nilai = $request->nilai;
        return updateStatus2(BibitMani::class, $id, $nilai, false, true, 'non aktif', 'aktif');*/
    }

    public function show($id)
    {
        $master = $this->myService->find(Reward::class, decodeId($id));

        $data =
            [
                'row' => $master,
            ];
        $view = 'mypanel.reward.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Reward::find(decodeId($id));

        $delete = $info->destroy(decodeId($id));
        if($delete) {
            $msgsuccess = 'berhasil hapus data';
            return res200(\request()->ajax(), $msgsuccess);
        } else {
            $msgerror = 'gagal hapus data';
            return res500(\request()->ajax(), $msgerror);
        }
    }



}
