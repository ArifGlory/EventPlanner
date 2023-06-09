<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\TransaksiEvent;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


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
                $aksiDetail = detailButtonDT($row->event_id, 'main/event/detail');
                $izin .= $aksiDetail;
                $aksiEdit = editButtonDT($row->event_id, 'main/event/edit');
                $aksiHapus = deleteButtonDT($row->event_id, 'deleteDataTable','event/delete');

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

    public function dataTransaksi(Request $request)
    {
        $event_id = $request->input('event_id');
        $data = TransaksiEvent::leftjoin('event', 'event.event_id', '=', 'transaksi_event.event_id')
            ->leftjoin('users', 'users.id', '=', 'transaksi_event.user_id')
            ->where('transaksi_event.event_id',$event_id)
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('dtResponsive', function () {
                return '';
            })
            ->addColumn('checkbox', function ($row) {
                $izin = checkboxRowDT($row->transaksi_event_id);
                return $izin;
            })
            ->editColumn('event_harga_tiket', function ($row) {
                return $row->event_harga_tiket ? format_angka_indo($row->event_harga_tiket) : '';
            })
            ->editColumn('name', function ($row) {
                if ($row->status == 1){
                    $name = $row->name." ".'<h6>'.$row->kode_tiket.'</h6>';
                }else{
                    $name = $row->name;
                }
                return $name;
            })
            ->editColumn('total_bayar', function ($row) {
                return $row->total_bayar ? format_angka_indo($row->total_bayar) : '';
            })
            ->editColumn('event_waktu', function ($row) {
                return $row->event_waktu ? TanggalIndowaktu($row->event_waktu) : '';
            })
            ->editColumn('bukti_bayar', function ($row) {
                return $row->bukti_bayar ? '<a class="image-popup-no-margins" href="'.getImageOri($row->bukti_bayar).'"><img class="img-thumbnail" style="width:100px; heigth:100px" src="'.getImageThumb($row->bukti_bayar).'"></a>' : '-';
            })
            ->addColumn('action', function ($row) {
                $izin = '';
                if (cekRoleAkses('store')){
                    if ($row->status == 0){
                        $aksiAccept = acceptButtonDT($row->transaksi_event_id, 'main/event/purchase/accept');
                        $izin .= $aksiAccept;

                        $aksiDecline  = declineButtonDT($row->transaksi_event_id,'main/event/purchase/decline');
                        $izin .= $aksiDecline;
                    }else if ($row->status == 1){
                        $info = '<h6><span class="badge badge-success">Pembelian Diverifikasi</span></h6>';
                        $izin .=$info;
                    }else if ($row->status == 2){
                        $info = '<h6><span class="badge badge-danger">Pembelian Ditolak</span></h6>';
                        $izin .=$info;
                    }
                }


                return aksiButton($izin);
            })
            ->escapeColumns([])
            ->toJson();
    }

    public function acceptPurchase($id){
        $transaksi = TransaksiEvent::find(decodeId($id));
        $event = Event::find($transaksi->event_id);

        if ($event->event_stok_tiket - $transaksi->jumlah <= 0){
            //stok tiket kurang
            $message = "Tidak dapat accept pembelian, stok tiket kurang";
            $msg['title'] = 'Gagal';
            $msg['status'] = false;
            $msg['tipe'] = 'error';
            $msg['message'] = $message;
            Session::flash('feedback', $msg);
        }else{
            $kode_tiket = random_bytes(3);
            $kode_tiket = bin2hex($kode_tiket);
            $kode_tiket = strtoupper($kode_tiket);

            $data_update['status'] = 1;
            $data_update['kode_tiket'] = $kode_tiket;
            $update = $transaksi->update($data_update);


            $message = "Pembelian berhasil diverifikasi";
            $msg['title'] = 'Berhasil';
            $msg['status'] = true;
            $msg['tipe'] = 'success';
            $msg['message'] = $message;
            Session::flash('feedback', $msg);

            $data_update_event['event_stok_tiket'] = $event->event_stok_tiket - $transaksi->jumlah;
            $event->update($data_update_event);
        }



        return $this->show(encodeId($transaksi->event_id));
    }

    public function declineForm($id){
        $transaksi = TransaksiEvent::leftjoin('event', 'event.event_id', '=', 'transaksi_event.event_id')
            ->leftjoin('users', 'users.id', '=', 'transaksi_event.user_id')
            ->where('transaksi_event.transaksi_event_id',decodeId($id))
            ->first();
        $data = [
            'mode' => 'add',
            'transaksi' => $transaksi,
            'action' => url('main/event/purchase/decline'),
            'id' => '',
        ];
        $view = 'mypanel.event.decline_form';
        return view($view, $data);
    }


    public function declinePurchase(Request $request){
        $id_transaksi = decodeId($request->input('id'));
        $transaksi = TransaksiEvent::find(decodeId($id_transaksi));
        $data_update['status'] = 2;
        $data_update['decline_reason'] = $request->input('decline_reason');
        //$data_update['bukti_bayar'] = null;
        $update = $transaksi->update($data_update);

        return redirect()->route('event.detail',encodeId($transaksi->event_id));
    }

    public function form()
    {
        $category = Category::where('created_by',null)
            ->orWhere('created_by',Auth::user()->id)
            ->get();

        $data = [
            'category' => $category,
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
            'event_rekening' => old('event_rekening', ''),
            'event_bank_rekening' => old('event_bank_rekening', ''),
            'event_latitude' => -5.441073410393852,
            'event_longitude' => 105.25861960614812,

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
            'event_rekening' => 'required',
            'event_bank_rekening' => 'required',
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
            'event_bank_rekening' => 'nama bank',
            'event_rekening' => 'no. rekening bank',
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
        $category = Category::where('created_by',null)
            ->orWhere('created_by',Auth::user()->id)
            ->get();

        if ($master->event_latitude){
            $lat = $master->event_latitude;
            $lon = $master->event_longitude;
        }else{
            $lat = -5.441073410393852;
            $lon = 105.25861960614812;
        }

        $data =
            [
                'mode' => 'edit',
                'category' => $category,
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
                'event_rekening' => old('event_rekening', $master->event_rekening),
                'event_bank_rekening' => old('event_bank_rekening', $master->event_bank_rekening),
                'event_latitude' => old('event_latitude', $lat),
                'event_longitude' => old('event_longitude', $lon),
            ];
        $view = 'mypanel.event.form';

        return view($view, $data);
    }

    public function update(Request $request, $id)
    {
        $master = $this->myService->find(Event::class, decodeId($id));

        $rule = [
            'event_category_id' => 'required',
            'event_name' => 'required',
            'event_waktu' => 'required',
            'event_talent' => 'required',
            'event_lokasi' => 'required',
            'event_harga_tiket' => 'required',
            'event_stok_tiket' => 'required',
            'event_description' => 'required',
            'event_latitude' => 'required',
            'event_longitude' => 'required',
            'event_rekening' => 'required',
            'event_bank_rekening' => 'required',
            //'event_poster' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $attributeRule = [
            'event_category_id' => 'Kategori event',
            'event_name' => 'nama event',
            'event_waktu' => 'waktu event',
            'event_talent' => 'talent event',
            'event_lokasi' => 'nama lokasi event',
            'event_harga_tiket' => 'harga tiket',
            'event_stok_tiket' => 'stok tiket',
            'event_description' => 'deskripsi tiket',
            'event_latitude' => 'latitdue',
            'event_longitude' => 'longitude',
            'event_rekening' => 'no. rekening',
            'event_bank_rekening' => 'nama bank',
            //'event_poster' => 'foto event',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();

        $gambar = $master->event_poster;
        if ($request->hasFile('event_poster')) {
            $gambar = StoreFileWithFolder($request->file('event_poster'), 'public', 'event', ['replace' => $master->event_poster]);
        } else {
            if (isset($request->remove_gambar)) {
                removeFileFolder('public', $master->event_poster);
                $gambar = null;
            }
        }
        $requestData['event_poster'] = $gambar;

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
        $master = Event::leftjoin('category', 'category.category_id', '=', 'event.event_category_id')
            ->where('event_id',decodeId($id))
            ->first();
        $transaksi = TransaksiEvent::where('event_id',$master->event_id)
            ->get();
        $event_time = substr($master->event_waktu,11,5);

        $data =
            [
                'row' => $master,
                'transaksi' => $transaksi,
                'event_time' => $event_time,
            ];
        $view = 'mypanel.event.show';
        return view($view, $data);
    }

    public function destroy($id){
        $info = Event::find(decodeId($id));

        $delete = $info->destroy(decodeId($id));
        if($delete) {
            $msgsuccess = 'berhasil hapus data';
            return res200(\request()->ajax(), $msgsuccess);
        } else {
            $msgerror = 'gagal hapus data';
            return res500(\request()->ajax(), $msgerror);
        }
    }

    public function reportForm(){
        $view = 'mypanel.event.report_form';
        $event = Event::where('created_by',Auth::user()->id)
            ->get();
        $data = [
            'mode' => 'add',
            'event' => $event,
            'action' => url('main/event/report/generate'),
        ];

        return view($view,$data);
    }

    public function generateReport(Request $request){
        $rule = [
           // 'from' => 'required',
            //'until' => 'required',
            'event_id' => 'required',
        ];
        $attributeRule = [
            'from' => 'Waktu Awal',
            'until' => 'waktu akhir',
            'event_id' => 'nama event',
            'is_transaksi' => 'apakah cetak transaksi',
        ];
        $this->validate($request,
            $rule,
            [],
            $attributeRule
        );

        $requestData = $request->all();
        $today = date('Y-m-d');
        $now = Carbon::createFromFormat('Y-m-d',$today)->format('d F Y');

        $transaksi = TransaksiEvent::leftjoin('users', 'users.id', '=', 'transaksi_event.user_id')
            ->where('transaksi_event.event_id',$requestData['event_id'])
            //->whereBetween('transaksi_event.created_at', [$requestData['from'], $requestData['until']])
            ->get();
        $event = Event::find($requestData['event_id']);

        $data = array(
            'event' => $event,
            'transaksi' => $transaksi,
            //'dari' => $dari,
            //'sampai' => $sampai,
            'user' => Auth::user(),
            'now' => $now,
        );

        $pdf = PDF::loadView('report_event',$data);

        return $pdf->download('report_event.pdf');


    }


}
