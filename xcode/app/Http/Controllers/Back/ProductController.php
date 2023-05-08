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
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;


class ProductController  extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['storeaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'product';
    }

    public function index()
    {
        $view = 'mypanel.product.index';
        $subcategory = SubCategory::all();
        $data = [
            'subcategory' => $subcategory,
        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        if (cekRoleAkses('store')){
            $data = Product::leftjoin('store', 'store.store_id', '=', 'product.store_id')
                ->where('store.store_pemilik',Auth::user()->id)
                ->get();
        }else if (cekRoleAkses('superadmin') || cekRoleAkses('admin')){
            $data = Product::get();
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
            ->addColumn('checkbox', function ($row) {
               /* $izin = '<i class="fas fa-ellipsis-h"></i>';
               if ( cekRoleAkses('superadmin') == true || cekRoleAkses('admin') == true ) {
                    $izin = checkboxRowDT($row->product_id);
                }*/
                $izin = checkboxRowDT($row->product_id);
                return $izin;
            })
            ->editColumn('product_price', function ($row) {
                return $row->product_price ? format_angka_indo($row->product_price) : '';
            })
            ->editColumn('product_old_price', function ($row) {
                return $row->product_old_price ? format_angka_indo($row->product_old_price) : '';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->product_id, 'main/product/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->product_id, 'main/product/edit');
                $aksiHapus = deleteButtonDT($row->product_id, 'deleteDataTable','product/delete');

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
            'action' => url('main/product/create'),
            'id' => '',
            'store_id' => old('store_id', ''),
            'subcategory_id' => old('subcategory_id', ''),
            'product_name' => old('product_name', ''),
            'product_price' => old('product_price', ''),
            'product_old_price' => old('product_old_price', ''),
            'product_currency' => old('product_currency', ''),
            'product_description' => old('product_description', ''),
            'product_url' => old('product_url', ''),
            'product_tags' => old('product_tags', ''),
            'product_image' => old('product_image', ''),
            'product_discount_start_date' => old('product_discount_start_date', ''),
            'product_discount_end_date' => old('product_discount_end_date', ''),
            'product_status' => old('product_status', ''),

        ];
        $view = 'mypanel.product.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'subcategory_id' => 'required',
            'store_id' => 'required',
            'product_name' => 'required',
            'product_tags' => 'required',
            'product_old_price' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
            'product_url' => 'required',
            'product_discount_start_date' => 'required',
            'product_discount_end_date' => 'required',
            'product_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'subcategory_id' => 'Kategori produk',
            'store_id' => 'Toko pemilik',
            'product_name' => 'nama produk',
            'product_tags' => 'Tag produk',
            'product_old_price' => 'harga awal produk',
            'product_price' => 'harga diskon produk',
            'product_description' => 'deskripsi produk',
            'product_url' => 'link url produk',
            'product_discount_start_date' => 'waktu mulai diskon',
            'product_discount_end_date' => 'waktu akhir diskon',
            'product_image' => 'foto produk',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;

        if ($request->hasFile('product_image')) {
            $requestData['product_image'] = StoreFileWithFolder($request->file('product_image'), 'public', 'produk');
        }


        return storeData(Product::class, $requestData, $this->context, true, 'main/product');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Product::class, decodeId($id));
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
                'action' => url('main/product/update/' . $id),
                'id' => $id,
                'store_id' => old('store_id', $master->store_id),
                'subcategory_id' => old('subcategory_id', $master->subcategory_id),
                'product_name' => old('product_name', $master->product_name),
                'product_price' => old('product_price', $master->product_price),
                'product_old_price' => old('product_old_price', $master->product_old_price),
                'product_currency' => old('product_currency', $master->product_currency),
                'product_description' => old('product_description', $master->product_description),
                'product_url' => old('product_url', $master->product_url),
                'product_tags' => old('product_tags', $master->product_tags),
                'product_image' => old('product_image', $master->product_image),
                'product_discount_start_date' => old('product_discount_start_date', $master->product_discount_start_date),
                'product_discount_end_date' => old('product_discount_end_date', $master->product_discount_end_date),
                'product_status' => old('product_status', $master->product_status),
            ];
        $view = 'mypanel.product.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Product::class, decodeId($id));

        $rule = [
            'subcategory_id' => 'required',
            'store_id' => 'required',
            'product_name' => 'required',
            'product_tags' => 'required',
            'product_old_price' => 'required',
            'product_price' => 'required',
            'product_description' => 'required',
            'product_url' => 'required',
            'product_discount_start_date' => 'required',
            'product_discount_end_date' => 'required',
            //'product_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'subcategory_id' => 'Kategori produk',
            'store_id' => 'Toko pemilik',
            'product_name' => 'nama produk',
            'product_tags' => 'Tag produk',
            'product_old_price' => 'harga awal produk',
            'product_price' => 'harga diskon produk',
            'product_description' => 'deskripsi produk',
            'product_url' => 'link url produk',
            'product_discount_start_date' => 'waktu mulai diskon',
            'product_discount_end_date' => 'waktu akhir diskon',
            //'product_image' => 'foto produk',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        $gambar = $master->product_image;
        if ($request->hasFile('product_image')) {
            $gambar = StoreFileWithFolder($request->file('product_image'), 'public', 'produk', ['replace' => $master->product_image]);
        } else {
            if (isset($request->remove_gambar)) {
                removeFileFolder('public', $master->product_image);
                $gambar = null;
            }
        }
        $requestData['product_image'] = $gambar;

        return updateData($master, $requestData, $this->context, true, 'main/product');
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
        $master = $this->myService->find(Product::class, decodeId($id));
        $store = Stores::find($master->store_id);
        $subcategory = SubCategory::find($master->subcategory_id);
        $tags = explode(",",$master->product_tags);
        $data =
            [
                'row' => $master,
                'tags' => $tags,
                'store' => $store,
                'subcategory' => $subcategory,
            ];
        $view = 'mypanel.product.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Product::find(decodeId($id));

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
