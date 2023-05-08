<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Models\Role;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    private $myService;

    public function __construct()
    {
        //$this->middleware(['auth', 'cekadmin']);
        $this->myService = new hideyoriService();
        $this->context = 'pengguna';
    }

    public function index()
    {
        $view = 'mypanel.user.index';
        $data = [
            'listRole' => Role::where('role.role_name','!=','superadmin')->get(),
        ];
        return view($view, $data);
    }

    public function data(Request $request)
    {
        $data = User::leftjoin('user_has_role', 'user_has_role.user_id', '=', 'users.id')
            ->leftjoin('role', 'role.id_role', '=', 'user_has_role.role_id')
            ->where('role.role_name','!=','superadmin');

        $roles = $request->get('roles');
        if($roles)
        {
            $data->where('role.id_role', $roles);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
                $izin = '<i class="fas fa-ellipsis-h"></i>';
               if (cekRoleAkses('superadmin') == true) {
                    /*if (Auth::user()->id != $row->id_users) {
                    }*/
                   $izin = checkboxRowDT($row->id);
                }

                return $izin;
            })
            ->editColumn('name', function ($row) {
                return '<div class="user-block"><a href="' . getImageOri($row->foto) . '" class="image-popup-no-margins"><img class="img-circle img-bordered-sm" src="' . getImageThumb($row->foto) . '" alt="' . $row->name . '"></a> <span class="username">' . $row->name . '</span> <span class="description">' . $row->email . '</span> </div>';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->id, 'main/pengguna/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->id, 'main/pengguna/edit');
                $aksiHapus = deleteButtonDT($row->id, 'deleteDataTable','pengguna/delete');
                if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    //$izin .= $aksiEdit;
                }
                if (cekRoleAkses('superadmin') == true){
                    $izin .= $aksiHapus;
                }

                return aksiButton($izin);
            })
            ->escapeColumns([])
            ->toJson();
    }


    public function updateStatus(Request $request)
    {
       /* $id = $request->id;
        $nilai = $request->nilai;
        return updateStatus2(User::class, $id, $nilai, true, false, 'Non Aktiv', 'Aktiv');*/
    }

    public function bulkStatus(Request $request)
    {
       /* $id = $request->id;
        $nilai = $request->nilai;
        return updateStatus2(User::class, $id, $nilai, false, true, 'Non Aktiv', 'Aktiv');*/
    }

    public function find(Request $request)
    {
        $member = Member::with(['ktp', 'user'])->whereHas('role', function ($q) use ($request) {
            $q->where('nama_role', $request->get('role'));
        })
            ->when($request->has('nama') && $request->get('nama') != '', function ($q) use ($request) {
                $q->whereHas('ktp', function ($q) use ($request) {
                    $q->where('nama', 'ilike', '%' . $request->nama . '%');
                });
            })
            ->when($request->has('nik') && $request->get('nik') != '', function ($q) use ($request) {
                $q->whereHas('ktp', function ($q) use ($request) {
                    $q->where('nik', 'ilike', '%' . $request->nik . '%');
                });
            })->get();

        return response($member);
    }

    public function show($id)
    {
        $master = $this->myService->find(User::class, decodeId($id));
        $data =
            [
                'row' => $master,
            ];
        $view = 'mypanel.user.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = User::find(decodeId($id));

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
