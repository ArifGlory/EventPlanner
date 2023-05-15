<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\Store;
use App\Models\Berita;
use App\Models\BibitMani;
use App\Models\Category;
use App\Models\ChildDetailKategori;
use App\Models\DetailKategori;
use App\Models\DetailStrawmani;
use App\Models\Event;
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


class BeritaController  extends Controller
{

    private $myService;

    public function __construct()
    {
        $this->middleware(['storeaccess']);
        $this->myService = new hideyoriService();
        $this->context = 'event';
    }

    public function index()
    {
        $view = 'mypanel.berita.index';
        $category = Category::all();
        $data = [
            'category' => $category,
        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        if (cekRoleAkses('store')){
            $data = Berita::select('berita.*','category.category_name')
                ->leftjoin('category', 'category.category_id', '=', 'berita.berita_category_id')
                ->where('berita.created_by',Auth::user()->id)
                ->get();
        }else if (cekRoleAkses('superadmin') || cekRoleAkses('admin')){
            $data = Berita::get();
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
                $izin = checkboxRowDT($row->berita_id);
                return $izin;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? TanggalIndowaktu($row->created_at) : '';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->berita_id, 'main/berita/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->berita_id, 'main/berita/edit');
                $aksiHapus = deleteButtonDT($row->berita_id, 'deleteDataTable','berita/delete');

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
            'category' => Category::all(),
            'mode' => 'add',
            'action' => url('main/berita/create'),
            'id' => '',
            'berita_title' => old('berita_title', ''),
            'berita_category_id' => old('berita_category_id', ''),
            'berita_content' => old('berita_content', ''),
            'berita_tag' => old('berita_tag', ''),
            'berita_image' => old('berita_image', ''),

        ];
        $view = 'mypanel.berita.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'berita_category_id' => 'required',
            'berita_name' => 'required',
            'berita_waktu' => 'required',
            'berita_talent' => 'required',
            'berita_lokasi' => 'required',
            'berita_harga_tiket' => 'required',
            'berita_stok_tiket' => 'required',
            'berita_description' => 'required',
            'berita_poster' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'berita_category_id' => 'Kategori event',
            'berita_name' => 'nama event',
            'berita_waktu' => 'waktu event',
            'berita_lokasi' => 'lokasi event',
            'berita_harga_tiket' => 'harga tiket event',
            'berita_stok_tiket' => 'stok tiket event',
            'berita_description' => 'deskripsi event',
            'berita_talent' => 'talent event',
            'berita_poster' => 'foto event',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;

        if ($request->hasFile('berita_poster')) {
            $requestData['berita_poster'] = StoreFileWithFolder($request->file('berita_poster'), 'public', 'event');
        }


        return storeData(Event::class, $requestData, $this->context, true, 'main/berita');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Event::class, decodeId($id));
        $selected_category = Category::find($master->berita_category_id);

        $data =
            [
                'mode' => 'edit',
                'category' => Category::all(),
                'selected_category' => $selected_category,
                'action' => url('main/berita/update/' . $id),
                'id' => $id,
                'berita_category_id' => old('subcategory_id', $master->berita_category_id),
                'berita_name' => old('berita_name', $master->berita_name),
                'berita_waktu' => old('berita_waktu', $master->berita_waktu),
                'berita_talent' => old('berita_talent', $master->berita_talent),
                'berita_lokasi' => old('berita_lokasi', $master->berita_lokasi),
                'berita_harga_tiket' => old('berita_harga_tiket', $master->berita_harga_tiket),
                'berita_stok_tiket' => old('berita_stok_tiket', $master->berita_stok_tiket),
                'berita_poster' => old('berita_poster', $master->berita_poster),
                'berita_description' => old('berita_description', $master->berita_description),
            ];
        $view = 'mypanel.berita.form';

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

        return updateData($master, $requestData, $this->context, true, 'main/berita');
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
        $view = 'mypanel.berita.show';
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
