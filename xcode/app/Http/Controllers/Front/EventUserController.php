<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BibitMani;
use App\Models\Event;
use App\Models\HargaKomoditas;
use App\Models\KomoditasTernak;
use App\Models\MaterialMaster;
use App\Models\Member;
use App\Models\Mission;
use App\Models\Pakan;
use App\Models\Penyedia;
use App\Models\PenyediaMaterial;
use App\Models\pilihPakan;
use App\Models\Product;
use App\Models\ProdukUsaha;
use App\Models\Slider;
use App\Models\Stores;
use App\Models\SubCategory;
use App\Models\Submission;
use App\Models\TransaksiEvent;
use App\Models\UPH;
use App\Models\Voucher;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class EventUserController extends Controller
{


    private $myService;

    public function __construct()
    {
        $this->myService = new hideyoriService();
        $this->context = 'tiket event';
    }

    public function index(Request $request)
    {
        $view = 'myfront.event.index';
        $now = date('Y-m-d');
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $event = Event::where('event_name','LIKE','%'.$keyword.'%')
                ->orderBy('event.created_at',"DESC")
                ->paginate(10);
        }else{
            $event = Event::where('event_waktu','>=',$now)
                ->orderBy('event.created_at',"DESC")
                ->paginate(10);
        }

        $data = [
            'event' => $event,
            'keyword' => $keyword
        ];

        return view($view, $data);
    }

    public function detailEvent($id){
        $view = 'myfront.event.detail_event';
        if (Auth::check()){
            $user_id = Auth::user()->id;
        }else{
            $user_id = 0;
        }

        $event = Event::select('event.*','users.id','users.name as planner')
            ->leftjoin('users', 'users.id', '=', 'event.created_by')
            ->where('event.event_id',decodeId($id))
            ->first();
        $other_event =  Event::inRandomOrder()
            ->limit(5)
            ->get();
        $event_time = substr($event->event_waktu,11,5);

        $data = [
            'event' => $event,
            'other_event' => $other_event,
            'event_time' => $event_time
        ];

        return view($view, $data);
    }

    public function buyTicket(Request $request){
        $view = 'myfront.event.buy_ticket_confirmation';
        $id = $request->input('id');
        $jumlah = $request->input('jumlah');

        $event = Event::find(decodeId($id));
        $total_bayar = $jumlah * $event->event_harga_tiket;
        $event_time = substr($event->event_waktu,11,5);

        $data = [
            'event' => $event,
            'jumlah' => $jumlah,
            'total_bayar' => $total_bayar,
            'event_time' => $event_time
        ];

        return view($view, $data);
    }

    public function storePurchase(Request $request){
        $id = $request->input('id');
        $jumlah = $request->input('jumlah');

        $event = Event::find(decodeId($id));
        $total_bayar = $jumlah * $event->event_harga_tiket;


        $data = array(
            'user_id' => Auth::user()->id,
            'event_id' => $event->event_id,
            'jumlah' => $jumlah,
            'total_bayar' => $total_bayar,
        );

        return storeData(TransaksiEvent::class, $data, $this->context, true, '/user');
    }

    public function purchaseDetail($id){
        $transaksi = TransaksiEvent::find(decodeId($id));
        $event = Event::find($transaksi->event_id);
        $view = 'myfront.event.purchase_detail';
        $event_time = substr($event->event_waktu,11,5);



        $data = array(
            'transaksi' => $transaksi,
            'event' => $event,
            'event_time' => $event_time,
        );

        return view($view, $data);
    }

    public function uploadPaymentProve(Request $request){
        $transaksi_id = $request->input('transaksi_event_id');
        $master = $this->myService->find(TransaksiEvent::class, decodeId($transaksi_id));

        $gambar = "";
        if ($request->hasFile('bukti_bayar')) {
            $gambar = StoreFileWithFolder($request->file('bukti_bayar'), 'public', 'bukti');
        }
        $requestData['bukti_bayar'] = $gambar;
        $requestData['status'] = 0;

        return updateData($master, $requestData, $this->context, true, '/purchase/detail/'.$transaksi_id,"berhasil upload bukti bayar");
    }

    public function eventDistribution(Request $request){
        $view = 'myfront.event.distribution';
        $now = date('Y-m-d');

        $event = Event::where('event_waktu','>=',$now)
            ->orderBy('event.created_at',"DESC")
            ->limit(50)
            ->get();
        foreach ($event as $val){
            $encoded_id = encodeId($val->event_id);
            $val->url_detail = url('/event/detail/'.$encoded_id);
        }

        $data = [
            'event' => $event,
            'event_latitude' => -5.441073410393852,
            'event_longitude' => 105.25861960614812,
        ];

        return view($view, $data);

    }



}
