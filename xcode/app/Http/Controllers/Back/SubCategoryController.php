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
use App\Models\SubCategory;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;


class SubCategoryController  extends Controller
{

    private $myService;

    public function __construct()
    {
        //$this->middleware(['cekadmin']);
        $this->myService = new hideyoriService();
        $this->context = 'subcategory';
    }

    public function index()
    {
        $view = 'mypanel.subcategory.index';
        $data = [
            //'listJenisSapi' => $listJenisSapi,
        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        $data = SubCategory::leftjoin('master_category', 'master_category.category_id', '=', 'master_sub_category.category_id')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
                $izin = '<i class="fas fa-ellipsis-h"></i>';
               if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin = checkboxRowDT($row->subcategory_id);
                }
                return $izin;
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                //$aksiDetail = detailButtonDT($row->subcategory_id, 'main/subcategory/detail');
               // $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->subcategory_id, 'main/subcategory/edit');
                $aksiHapus = deleteButtonDT($row->subcategory_id, 'deleteDataTable','subcategory/delete');
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
        $category = Category::all();
        $data = [
            'mode' => 'add',
            'action' => url('main/subcategory/create'),
            'id' => '',
            'category' => $category,
            'subcategory_name' => old('subcategory_name', ''),

        ];
        $view = 'mypanel.subcategory.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'subcategory_name' => 'required',
            'category_id' => 'required',
        ];
        $attributeRule = [
            'subcategory_name' => 'Nama Sub Category',
            'category_id' => 'Kategori',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        unset($requestData['_token']);

        return storeData(SubCategory::class, $requestData, $this->context, true, 'main/subcategory');
    }

    public function edit($id)
    {
        $master = $this->myService->find(SubCategory::class, decodeId($id));
        $category = Category::all();
        $selected_category = Category::find($master->category_id);

        $data =
            [
                'mode' => 'edit',
                'action' => url('main/subcategory/update/' . $id),
                'id' => $id,
                'category' => $category,
                'selected_category' => $selected_category,
                'subcategory_name' => old('subcategory_name', $master->subcategory_name),
            ];
        $view = 'mypanel.subcategory.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(SubCategory::class, decodeId($id));

        $rule = [
            'subcategory_name' => 'required',
            'category_id' => 'required',
        ];
        $attributeRule = [
            'subcategory_name' => 'Nama Sub Category',
            'category_id' => 'kategori',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        return updateData($master, $requestData, $this->context, true, 'main/subcategory');
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
        $master = $this->myService->find(SubCategory::class, decodeId($id));
        $data =
            [
                'row' => $master,
            ];
        $view = 'mypanel.subcategory.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = SubCategory::find(decodeId($id));

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
