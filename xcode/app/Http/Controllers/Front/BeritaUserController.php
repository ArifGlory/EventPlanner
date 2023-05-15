<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Berita;
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


class BeritaUserController extends Controller
{


    public function index(Request $request)
    {
        $view = 'myfront.berita.index';
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $berita = Berita::where('berita_title','LIKE','%'.$keyword.'%')
                ->orderBy('created_at',"DESC")
                ->paginate(10);
        }else{
            $berita = Berita::orderBy('created_at',"DESC")
                ->paginate(10);
        }

        $data = [
            'berita' => $berita,
            'keyword' => $keyword
        ];

        return view($view, $data);
    }

    public function detail($id){
        $view = 'myfront.berita.detail_berita';

        $berita = Berita::select('berita.*','category.category_name')
            ->leftjoin('category', 'category.category_id', '=', 'berita.berita_category_id')
            ->where('berita_id',decodeId($id))
            ->first();
        $other_berita =  Berita::inRandomOrder()
            ->limit(5)
            ->get();

        $data = [
            'berita' => $berita,
            'other_berita' => $other_berita,
        ];

        return view($view, $data);
    }

    public function buyTicket($id){
        dd("buying tickets..");
    }



}
