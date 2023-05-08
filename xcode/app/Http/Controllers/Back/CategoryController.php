<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\BibitMani;
use App\Models\Category;
use App\Models\ChildDetailKategori;
use App\Models\DetailKategori;
use App\Models\DetailStrawmani;
use App\Models\JenisSapi;
use App\Models\MaterialMaster;
use App\Models\Penyedia;
use App\Models\PenyediaMaterial;
use App\Models\PenyediaMaterialHarga;
use App\Models\Stores;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;


class CategoryController  extends Controller
{

    private $myService;

    public function __construct()
    {
        //$this->middleware(['cekadmin']);
        $this->myService = new hideyoriService();
        $this->context = 'category';
    }

    public function index()
    {
        $view = 'mypanel.category.index';
        $data = [
            //'listJenisSapi' => $listJenisSapi,
        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        $data = Category::get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
                $izin = '<i class="fas fa-ellipsis-h"></i>';
               if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin = checkboxRowDT($row->category_id);
                }
                return $izin;
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->category_id, 'main/category/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->category_id, 'main/category/edit');
                $aksiHapus = deleteButtonDT($row->category_id, 'deleteDataTable','category/delete');
                if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
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
            'action' => url('main/category/create'),
            'id' => '',
            'category_name' => old('category_name', ''),

        ];
        $view = 'mypanel.category.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'category_name' => 'required',
        ];
        $attributeRule = [
            'category_name' => 'Nama Category',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        return storeData(Category::class, $requestData, $this->context, true, 'main/category');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Category::class, decodeId($id));

        $data =
            [
                'mode' => 'edit',
                'action' => url('main/category/update/' . $id),
                'id' => $id,
                'category_name' => old('category_name', $master->category_name),
            ];
        $view = 'mypanel.category.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Category::class, decodeId($id));

        $rule = [
            'category_name' => 'required',
        ];
        $attributeRule = [
            'category_name' => 'Nama Category',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        return updateData($master, $requestData, $this->context, true, 'main/category');
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
        $master = $this->myService->find(Category::class, decodeId($id));
        $data =
            [
                'row' => $master,
            ];
        $view = 'mypanel.category.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Category::find(decodeId($id));

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
