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
               // $izin .= $aksiDetail;
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
            'berita_title' => 'required',
            'berita_content' => 'required',
            'berita_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'berita_category_id' => 'Kategori event',
            'berita_title' => 'nama event',
            'berita_content' => 'deskripsi event',
            'berita_image' => 'foto event',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $requestData['created_by'] = Auth::user()->id;

        if ($request->hasFile('berita_image')) {
            $requestData['berita_image'] = StoreFileWithFolder($request->file('berita_image'), 'public', 'berita');
        }


        return storeData(Berita::class, $requestData, $this->context, true, 'main/berita');
    }

    public function edit($id)
    {
        $master = $this->myService->find(Berita::class, decodeId($id));
        $selected_category = Category::find($master->berita_category_id);

        $data =
            [
                'mode' => 'edit',
                'category' => Category::all(),
                'selected_category' => $selected_category,
                'action' => url('main/berita/update/' . $id),
                'id' => $id,
                'berita_category_id' => old('berita_category_id', $master->berita_category_id),
                'berita_title' => old('berita_title', $master->berita_title),
                'berita_image' => old('berita_image', $master->berita_image),
                'berita_content' => old('berita_content', $master->berita_content),
            ];
        $view = 'mypanel.berita.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Berita::class, decodeId($id));

        $rule = [
            'berita_category_id' => 'required',
            'berita_title' => 'required',
            'berita_content' => 'required',
            //'product_image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'berita_category_id' => 'Kategori berita',
            'berita_title' => 'judul berita',
            'berita_content' => 'konten berita',
            //'product_image' => 'foto produk',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        $gambar = $master->berita_image;
        if ($request->hasFile('berita_image')) {
            $gambar = StoreFileWithFolder($request->file('berita_image'), 'public', 'berita', ['replace' => $master->berita_image]);
        } else {
            if (isset($request->remove_gambar)) {
                removeFileFolder('public', $master->berita_image);
                $gambar = null;
            }
        }
        $requestData['berita_image'] = $gambar;

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
        $master = $this->myService->find(Berita::class, decodeId($id));
        $category = Category::find($master->berita_category_id);
        //$tags = explode(",",$master->product_tags);
        $data =
            [
                'row' => $master,
                'category' => $category,
            ];
        $view = 'mypanel.berita.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Berita::find(decodeId($id));

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
