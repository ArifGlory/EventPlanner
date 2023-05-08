<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\BibitMani;
use App\Models\ChildDetailKategori;
use App\Models\DetailKategori;
use App\Models\DetailStrawmani;
use App\Models\JenisSapi;
use App\Models\MaterialMaster;
use App\Models\Penyedia;
use App\Models\PenyediaMaterial;
use App\Models\PenyediaMaterialHarga;
use App\Models\Stores;
use App\Models\User;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;


class StoreController  extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['storeaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'stores';
    }

    public function index()
    {
        $view = 'mypanel.store.index';
        $data = [
            //'listJenisSapi' => $listJenisSapi,
        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        if (cekRoleAkses('store')){
            $data = Stores::where('store_pemilik',Auth::user()->id)
                ->get();
        }else if (cekRoleAkses('superadmin') || cekRoleAkses('admin')){
            $data = Stores::get();
        }

        /*$created_by = $request->get('created_by');
        if ($created_by) {
            $data->where('created_by', $created_by);
        }
        $jenis_id = $request->get('jenis_id');
        if ($jenis_id) {
            $data->whereIn('jenis_id', $jenis_id);
        }*/
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
//            ->addColumn('jenis', function ($row) {
//                return $row->jenis;
//            })
            ->addColumn('checkbox', function ($row) {
                $izin = '<i class="fas fa-ellipsis-h"></i>';
               if ( cekRoleAkses('superadmin') || cekRoleAkses('admin') || cekRoleAkses('store')) {
                    $izin = checkboxRowDT($row->store_id);
               }
                return $izin;
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->store_id, 'main/stores/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->store_id, 'main/stores/edit');
                $aksiHapus = deleteButtonDT($row->store_id, 'deleteDataTable','stores/delete');
                if ( cekRoleAkses('superadmin') || cekRoleAkses('admin') || cekRoleAkses('store') ) {
                    $izin .= $aksiEdit;
                }
                if (cekRoleAkses('superadmin') == true){
                    $izin .= $aksiHapus;
                }

                return aksiButton($izin);
            })
            ->escapeColumns([])
            ->toJson();
    }


    public function form()
    {
        $data = [
            'mode' => 'add',
            'action' => url('main/stores/create'),
            'id' => '',
            'store_name' => old('store_name', ''),
            'store_pemilik' => old('store_pemilik', ''),
            'store_type' => old('store_type', ''),
            'store_description' => old('store_description', ''),
            'store_tags' => old('store_tags', ''),
            'store_logo' => old('store_logo', ''),
            'store_phone' => old('store_phone', ''),
            'store_url' => old('store_url', ''),

        ];
        $view = 'mypanel.store.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        if (cekRoleAkses('store')){
            $rule = [
                'store_name' => 'required',
                'store_type' => 'required',
                'store_description' => 'required',
                'store_tags' => 'required',
                'store_logo' => 'required|mimes:jpeg,png,jpg|max:2048',
                'store_phone' => 'required',
                'store_url' => 'required',
            ];

            $attributeRule = [
                'store_name' => 'Nama Toko',
                'store_type' => 'tipe toko',
                'store_description' => 'Deskripsi Toko',
                'store_tags' => 'Tag toko',
                'store_logo' => 'Gambar',
                'store_phone' => 'No Telepon',
                'store_url' => 'URL Toko',
            ];
        }else{
            $rule = [
                'store_pemilik' => 'required',
                'store_name' => 'required',
                'store_type' => 'required',
                'store_description' => 'required',
                'store_tags' => 'required',
                'store_logo' => 'required|mimes:jpeg,png,jpg|max:2048',
                'store_phone' => 'required',
                'store_url' => 'required',
            ];

            $attributeRule = [
                'store_pemilik' => 'Pemilik Toko',
                'store_name' => 'Nama Toko',
                'store_type' => 'tipe toko',
                'store_description' => 'Deskripsi Toko',
                'store_tags' => 'Tag toko',
                'store_logo' => 'Gambar',
                'store_phone' => 'No Telepon',
                'store_url' => 'URL Toko',
            ];
        }

        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        if (cekRoleAkses('store')){
            $requestData['store_pemilik'] = Auth::user()->id;
        }

        if ($request->hasFile('store_logo')) {
            $requestData['store_logo'] = StoreFileWithFolder($request->file('store_logo'), 'public', 'toko');
        }


        return storeData(Stores::class, $requestData, $this->context, true, 'main/stores');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Stores::class, decodeId($id));
        $pemilik = User::find($master->store_pemilik);

        $data =
            [
                'mode' => 'edit',
                'action' => url('main/stores/update/' . $id),
                'id' => $id,
                'pemilik' => $pemilik,
                'store_pemilik' => old('store_pemilik', $master->store_pemilik),
                'store_name' => old('store_name', $master->store_name),
                'store_type' => old('store_type', $master->store_type),
                'store_description' => old('store_description', $master->store_description),
                'store_tags' => old('store_tags', $master->store_tags),
                'store_logo' => old('store_logo', $master->store_logo),
                'store_phone' => old('store_phone', $master->store_phone),
                'store_url' => old('store_url', $master->store_url),

            ];
        $view = 'mypanel.store.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Stores::class, decodeId($id));

        $rule = [
            'store_name' => 'required',
            'store_type' => 'required',
            'store_description' => 'required',
            'store_tags' => 'required',
            'store_phone' => 'required',
            'store_url' => 'required',
        ];
        $attributeRule = [
            'store_name' => 'Nama Toko',
            'store_type' => 'tipe toko',
            'store_description' => 'Deskripsi Toko',
            'store_tags' => 'Tag toko',
            'store_logo' => 'Gambar',
            'store_phone' => 'No Telepon',
            'store_url' => 'URL Toko',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        $gambar = $master->store_logo;
        if ($request->hasFile('store_logo')) {
            $gambar = StoreFileWithFolder($request->file('store_logo'), 'public', 'toko', ['replace' => $master->store_logo]);
        } else {
            if (isset($request->remove_gambar)) {
                removeFileFolder('public', $master->store_logo);
                $gambar = null;
            }
        }
        $requestData['store_logo'] = $gambar;

        return updateData($master, $requestData, $this->context, true, 'main/stores');
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
        $master = $this->myService->find(Stores::class, decodeId($id));
        $tags = explode(",",$master->store_tags);
        $data =
            [
                'row' => $master,
                'tags' => $tags,
            ];
        $view = 'mypanel.store.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Stores::find(decodeId($id));

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
