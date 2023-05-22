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
use App\Models\Pakan;
use App\Models\Penyedia;
use App\Models\PenyediaMaterial;
use App\Models\pilihPakan;
use App\Models\Product;
use App\Models\ProdukUsaha;
use App\Models\Role;
use App\Models\Slider;
use App\Models\Stores;
use App\Models\SubCategory;
use App\Models\Submission;
use App\Models\TransaksiEvent;
use App\Models\UPH;
use App\Models\UserHasRole;
use App\Models\Voucher;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class ProfileUserController extends Controller
{


    public function index()
    {
        $view = 'myfront.user.profil';
        $count_event = Event::where('created_by',Auth::user()->id)
            ->count();
        $count_berita = Berita::where('created_by',Auth::user()->id)
            ->count();
        $count_tiket_owned = TransaksiEvent::where('user_id',Auth::user()->id)
            ->count();
        $new_tiket_owned = TransaksiEvent::leftjoin('event', 'event.event_id', '=', 'transaksi_event.event_id')
            ->where('transaksi_event.user_id',Auth::user()->id)
            ->orderBy('transaksi_event.created_at',"DESC")
            ->limit(10)
            ->get();

        $data = [
            'count_event' => $count_event,
            'count_berita' => $count_berita,
            'count_tiket_owned' => $count_tiket_owned,
            'new_tiket_owned' => $new_tiket_owned,
        ];

        return view($view, $data);
    }

    public function addRoleStore(){
        $id_role_store = getRoleStore();
        $cek = UserHasRole::where('role_id',$id_role_store)
            ->where('user_id',Auth::user()->id)
            ->first();
        if ($cek){
            $msgerror = 'Akun anda telah terdaftar sebagai Pemilik Store';
            return res500(\request()->ajax(), $msgerror);
        }else{
            $usr_has_role = UserHasRole::create([
                'user_id' => Auth::user()->id,
                'role_id' => $id_role_store,
            ]);

            $msgsuccess = 'Selamat ! ,  anda berhasil bergabung menjadi pemilik store';
            return res200(\request()->ajax(), $msgsuccess);
        }
    }



}
