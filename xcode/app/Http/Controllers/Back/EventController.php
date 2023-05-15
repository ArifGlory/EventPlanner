<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\Store;
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


class EventController  extends Controller
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
        $view = 'mypanel.event.index';
        $category = Category::all();
        $data = [
            'category' => $category,
        ];

        return view($view, $data);
    }

    public function data(Request $request)
    {
        if (cekRoleAkses('store')){
            $data = Event::leftjoin('category', 'category.category_id', '=', 'event.event_category_id')
                ->where('event.created_by',Auth::user()->id)
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
                $izin = checkboxRowDT($row->event_id);
                return $izin;
            })
            ->editColumn('event_harga_tiket', function ($row) {
                return $row->event_harga_tiket ? format_angka_indo($row->event_harga_tiket) : '';
            })
            ->editColumn('event_waktu', function ($row) {
                return $row->event_waktu ? TanggalIndowaktu($row->event_waktu) : '';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                $aksiDetail = detailButtonDT($row->product_id, 'main/event/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->event_id, 'main/event/edit');
                $aksiHapus = deleteButtonDT($row->event_id, 'deleteDataTable','product/delete');

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
            'action' => url('main/event/create'),
            'id' => '',
            'event_name' => old('event_name', ''),
            'event_category_id' => old('event_category_id', ''),
            'event_waktu' => old('event_waktu', ''),
            'event_talent' => old('event_talent', ''),
            'event_lokasi' => old('event_lokasi', ''),
            'event_harga_tiket' => old('event_harga_tiket', ''),
            'event_stok_tiket' => old('event_stok_tiket', ''),
            'event_poster' => old('event_poster', ''),
            'event_discount' => old('event_discount', ''),
            'event_description' => old('event_description', ''),

        ];
        $view = 'mypanel.event.form';
        return view($view, $data);
    }

    public function store(Request $request)
    {

        $rule = [
            'event_category_id' => 'required',
            'event_name' => 'required',
            'event_waktu' => 'required',
            'event_talent' => 'required',
            'event_lokasi' => 'required',
            'event_harga_tiket' => 'required',
            'event_stok_tiket' => 'required',
            'event_description' => 'required',
            'event_poster' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'event_category_id' => 'Kategori event',
            'event_name' => 'nama event',
            'event_waktu' => 'waktu event',
            'event_lokasi' => 'lokasi event',
            'event_harga_tiket' => 'harga tiket event',
            'event_stok_tiket' => 'stok tiket event',
            'event_description' => 'deskripsi event',
            'event_talent' => 'talent event',
            'event_poster' => 'foto event',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;

        if ($request->hasFile('event_poster')) {
            $requestData['event_poster'] = StoreFileWithFolder($request->file('event_poster'), 'public', 'event');
        }


        return storeData(Event::class, $requestData, $this->context, true, 'main/event');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Event::class, decodeId($id));
        $selected_category = Category::find($master->event_category_id);

        $data =
            [
                'mode' => 'edit',
                'category' => Category::all(),
                'selected_category' => $selected_category,
                'action' => url('main/event/update/' . $id),
                'id' => $id,
                'event_category_id' => old('subcategory_id', $master->event_category_id),
                'event_name' => old('event_name', $master->event_name),
                'event_waktu' => old('event_waktu', $master->event_waktu),
                'event_talent' => old('event_talent', $master->event_talent),
                'event_lokasi' => old('event_lokasi', $master->event_lokasi),
                'event_harga_tiket' => old('event_harga_tiket', $master->event_harga_tiket),
                'event_stok_tiket' => old('event_stok_tiket', $master->event_stok_tiket),
                'event_poster' => old('event_poster', $master->event_poster),
                'event_description' => old('event_description', $master->event_description),
            ];
        $view = 'mypanel.event.form';

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

        return updateData($master, $requestData, $this->context, true, 'main/event');
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
        $view = 'mypanel.event.show';
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