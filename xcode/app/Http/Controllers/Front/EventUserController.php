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
use App\Models\UPH;
use App\Models\Voucher;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class EventUserController extends Controller
{


    public function index(Request $request)
    {
        $view = 'myfront.event.index';
        $now = date('Y-m-d');
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $event = Event::where('event_name','LIKE','%'.$keyword.'%')
                ->paginate(10);
        }else{
            $event = Event::where('event_waktu','>=',$now)
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

        $event = Event::find(decodeId($id));
        $other_event =  Event::inRandomOrder()
            ->limit(5)
            ->get();
        $isJoined = false;
        $event_time = substr($event->event_waktu,11,5);

        $data = [
            'event' => $event,
            'other_event' => $other_event,
            'isJoined' => $isJoined,
            'event_time' => $event_time
        ];

        return view($view, $data);
    }

    public function buyTicket($id){
        dd("buying tickets..");
    }



}
