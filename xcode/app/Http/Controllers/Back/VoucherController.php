<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\Store;
use App\Models\BibitMani;
use App\Models\ChildDetailKategori;
use App\Models\DetailKategori;
use App\Models\DetailStrawmani;
use App\Models\JenisSapi;
use App\Models\MaterialMaster;
use App\Models\Penyedia;
use App\Models\PenyediaMaterial;
use App\Models\PenyediaMaterialHarga;
use App\Models\Product;
use App\Models\Stores;
use App\Models\SubCategory;
use App\Models\Voucher;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;


class VoucherController  extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['storeaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'voucher';
    }

    public function index()
    {
        $view = 'mypanel.voucher.index';
        $subcategory = SubCategory::all();
        $data = [
            'subcategory' => $subcategory,
        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        if (cekRoleAkses('store')){
            $data = Voucher::leftjoin('store', 'store.store_id', '=', 'voucher.store_id')
                ->where('store.store_pemilik',Auth::user()->id)
                ->get();
        }else if (cekRoleAkses('superadmin') || cekRoleAkses('admin')){
            $data = Voucher::leftjoin('store', 'store.store_id', '=', 'voucher.store_id')
                ->get();
        }

       /* $created_by = $request->get('created_by');
        if ($created_by) {
            $data->where('created_by', $created_by);
        }*/

        $jenis_id = $request->get('jenis_id');
        if ($jenis_id) {
            $data->whereIn('voucher.subcategory_id', $jenis_id);
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
               /* $izin = '<i class="fas fa-ellipsis-h"></i>';
               if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin = checkboxRowDT($row->voucher_id);
                }*/
                $izin = checkboxRowDT($row->voucher_id);
                return $izin;
            })
            ->editColumn('voucher_end_date', function ($row) {
                return $row->voucher_end_date ? TanggalIndo($row->voucher_end_date) : '';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->voucher_id, 'main/voucher/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->voucher_id, 'main/voucher/edit');
                $aksiHapus = deleteButtonDT($row->voucher_id, 'deleteDataTable','voucher/delete');

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
        if (cekRoleAkses('store')){
            $stores = Stores::where('store_pemilik',Auth::user()->id)
                ->get();
        }else{
            $stores = Stores::all();
        }

        $data = [
            'subcategory' => SubCategory::all(),
            'stores' => $stores,
            'mode' => 'add',
            'action' => url('main/voucher/create'),
            'id' => '',
            'store_id' => old('store_id', ''),
            'subcategory_id' => old('subcategory_id', ''),
            'voucher_name' => old('voucher_name', ''),
            'voucher_code' => old('voucher_code', ''),
            'voucher_url' => old('voucher_url', ''),
            'voucher_description' => old('voucher_description', ''),
            'voucher_tags' => old('voucher_tags', ''),
            'voucher_image' => old('voucher_image', ''),
            'voucher_start_date' => old('voucher_start_date', ''),
            'voucher_end_date' => old('voucher_end_date', ''),
            'voucher_status' => old('voucher_status', ''),

        ];
        $view = 'mypanel.voucher.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'subcategory_id' => 'required',
            'store_id' => 'required',
            'voucher_name' => 'required',
            'voucher_url' => 'required',
            'voucher_tags' => 'required',
            'voucher_description' => 'required',
            'voucher_start_date' => 'required',
            'voucher_end_date' => 'required',
            'voucher_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'subcategory_id' => 'Kategori',
            'store_id' => 'Toko pemilik',
            'voucher_name' => 'nama',
            'voucher_url' => 'Link URL voucher',
            'voucher_tags' => 'Tag produk',
            'voucher_description' => 'deskripsi ',
            'voucher_start_date' => 'waktu mulai voucher',
            'voucher_end_date' => 'waktu akhir voucher',
            'voucher_image' => 'foto voucher',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;

        if ($request->hasFile('voucher_image')) {
            $requestData['voucher_image'] = StoreFileWithFolder($request->file('voucher_image'), 'public', 'voucher');
        }


        return storeData(Voucher::class, $requestData, $this->context, true, 'main/voucher');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Voucher::class, decodeId($id));
        $selected_stores = Stores::find($master->store_id);
        $selected_subcategory = SubCategory::find($master->subcategory_id);
        if (cekRoleAkses('store')){
            $stores = Stores::where('store_pemilik',Auth::user()->id)
                ->get();
        }else{
            $stores = Stores::all();
        }

        $data =
            [
                'mode' => 'edit',
                'subcategory' => SubCategory::all(),
                'stores' => $stores,
                'selected_stores' => $selected_stores,
                'selected_subcategory' => $selected_subcategory,
                'action' => url('main/voucher/update/' . $id),
                'id' => $id,
                'store_id' => old('store_id', $master->store_id),
                'subcategory_id' => old('subcategory_id', $master->subcategory_id),
                'voucher_name' => old('voucher_name', $master->voucher_name),
                'voucher_code' => old('voucher_code', $master->voucher_code),
                'voucher_url' => old('voucher_url', $master->voucher_url),
                'voucher_description' => old('voucher_description', $master->voucher_description),
                'voucher_tags' => old('voucher_tags', $master->voucher_tags),
                'voucher_image' => old('voucher_image', $master->voucher_image),
                'voucher_start_date' => old('voucher_start_date', $master->voucher_start_date),
                'voucher_end_date' => old('voucher_end_date', $master->voucher_end_date),
                'voucher_status' => old('voucher_status', $master->voucher_status),
            ];

        $view = 'mypanel.voucher.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Voucher::class, decodeId($id));

        $rule = [
            'subcategory_id' => 'required',
            'store_id' => 'required',
            'voucher_name' => 'required',
            'voucher_tags' => 'required',
            'voucher_url' => 'required',
            'voucher_description' => 'required',
            'voucher_start_date' => 'required',
            'voucher_end_date' => 'required',
            //'voucher_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'subcategory_id' => 'Kategori produk',
            'store_id' => 'Toko pemilik',
            'voucher_name' => 'nama produk',
            'voucher_tags' => 'Tag produk',
            'voucher_url' => 'voucher url',
            'voucher_description' => 'deskripsi produk',
            'voucher_start_date' => 'waktu mulai diskon',
            'voucher_end_date' => 'waktu akhir diskon',
            //'voucher_image' => 'foto produk',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        $gambar = $master->voucher_image;
        if ($request->hasFile('voucher_image')) {
            $gambar = StoreFileWithFolder($request->file('voucher_image'), 'public', 'voucher', ['replace' => $master->voucher_image]);
        } else {
            if (isset($request->remove_gambar)) {
                removeFileFolder('public', $master->voucher_image);
                $gambar = null;
            }
        }
        $requestData['voucher_image'] = $gambar;

        return updateData($master, $requestData, $this->context, true, 'main/voucher');
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
        $master = $this->myService->find(Voucher::class, decodeId($id));
        $store = Stores::find($master->store_id);
        $subcategory = SubCategory::find($master->subcategory_id);
        $tags = explode(",",$master->voucher_tags);
        $data =
            [
                'row' => $master,
                'tags' => $tags,
                'store' => $store,
                'subcategory' => $subcategory,
            ];
        $view = 'mypanel.voucher.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Voucher::find(decodeId($id));

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
