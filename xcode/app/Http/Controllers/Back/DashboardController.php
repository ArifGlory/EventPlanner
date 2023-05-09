<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\BibitMani;
use App\Models\ChildDetailKategori;
use App\Models\DetailKategori;
use App\Models\Event;
use App\Models\Gudang;
use App\Models\JenisSapi;
use App\Models\KomoditasTernak;
use App\Models\MaterialMaster;
use App\Models\Member;
use App\Models\Mission;
use App\Models\Pakan;
use App\Models\Penyedia;
use App\Models\Product;
use App\Models\ProdukUsaha;
use App\Models\Stores;
use App\Models\Submission;
use App\Models\UPH;
use App\Models\User;
use App\Services\hideyoriService;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    private $myService;

    public function __construct()
    {
        //$this->middleware(['cekadmin']);
        $this->myService = new hideyoriService();
    }

    public function index()
    {

        $data = [
            'event' => Event::where('event_pemilik',Auth::user()->id)
                ->count(),
        ];

        $view = 'mypanel.dashboard.index';

        return view($view, $data);
    }

    public function getDataPengguna(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            if ($search) {
                if (cekRoleAkses('superadmin') || cekRoleAkses('admin')) {

                    $data = User::where('level', "user")
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        //->orWhere('wallet_address', 'ilike', '%' . $search . '%')
                        ->get();
                } else {
                    $data = array();
                }

            } else {

                if (cekRoleAkses('superadmin') || cekRoleAkses('admin')) {
                    $data = User::where('level', "user")
                        ->inRandomOrder()
                        ->limit(100)
                        ->get();
                } else {
                    $data = array();
                }
            }
            return response()->json($data);
        }
    }


}
