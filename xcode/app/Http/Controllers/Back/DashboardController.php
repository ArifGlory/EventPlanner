<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\BibitMani;
use App\Models\ChildDetailKategori;
use App\Models\DetailKategori;
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

        $data = array();
        if (cekRoleAkses('superadmin') || cekRoleAkses('admin')) {
            $mission_waiting = Submission::select('mission_submission.*',
                'users.name',
                'users.email',
                'mission.mission_id',
                'mission.mission_name',
                )
                ->leftjoin('users', 'users.id', '=', 'mission_submission.user_id')
                ->leftjoin('mission', 'mission.mission_id', '=', 'mission_submission.mission_id')
                ->select('mission_submission.*','users.name')
                ->whereIn('submission_status',['waiting','submitted','half-declined'])
                //->orWhere('submission_status',"submitted")
                ->get();
            $data = [
                'store' => Stores::count(),
                'produk' => Product::count(),
                'mission' => Mission::count(),
                'isAdmin' => true,
                'mission_waiting' => $mission_waiting,
            ];
        } else if (cekRoleAkses('store')) {
            $data = [
                'produk' => Product::leftjoin('store', 'store.store_id', '=', 'product.store_id')
                    ->where('store.store_pemilik',Auth::user()->id)
                    ->count(),
                'mission' => Mission::where('created_by',Auth::user()->id)
                    ->count(),
                'isAdmin' => false,
            ];
        }
        //dd($data);

        $view = 'mypanel.dashboard.index';
        //$data = array_merge($dataAdmin);
        return view($view, $data);
    }

    public function getMember(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            if ($search) {
                if (cekRoleAkses('admin kabupaten')) {
                    $idkab = Auth::user()->member->id_kab ?? '';
                    $data = Member::with('ktp')->where('nik', 'like', '%' . $search . '%')
                        ->whereHas('user')->orWhereHas('ktp', function ($q) use ($search) {
                            $q->where('nama', 'ilike', '%' . $search . '%');
                        })->whereHas('user')->where('id_kab', $idkab)->get();
                } else {
                    $data = Member::with('ktp')->where('nik', 'like', '%' . $search . '%')
                        ->whereHas('user')->orWhereHas('ktp', function ($q) use ($search) {
                            $q->where('nama', 'ilike', '%' . $search . '%');
                        })->whereHas('user')->get();
                }


            } else {

                if (cekRoleAkses('admin kabupaten')) {
                    $idkab = Auth::user()->member->id_kab ?? '';
                    $data = Member::where('id_kab', $idkab)->with('ktp')
                        ->whereHas('ktp')->whereHas('user')->inRandomOrder()->limit(100)->get();
                } else {
                    $data = Member::with('ktp')
                        ->whereHas('ktp')->whereHas('user')->inRandomOrder()->limit(100)->get();
                }
            }
            return response()->json($data);
        }
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

    public function getUPH(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            if ($search) {
                if (cekRoleAkses('admin kabupaten')) {
                    $idkab = Auth::user()->member->id_kab ?? '';
                    $data = UPH::with('member')
                        ->WhereHas('member', function ($q) use ($idkab) {
                            $q->where('id_kab', $idkab);
                        })
                        ->where('uph_nama', 'like', '%' . $search . '%')->get();
                } else {
                    $data = UPH::where('uph_nama', 'like', '%' . $search . '%')->get();
                }
            } else {
                if (cekRoleAkses('admin kabupaten')) {
                    $idkab = Auth::user()->member->id_kab ?? '';
                    $data = UPH::with('member')
                        ->WhereHas('member', function ($q) use ($idkab) {
                            $q->where('id_kab', $idkab);
                        })
                        ->orderBy('uph_nama', 'ASC')->limit(100)->get();
                } else {
                    $data = UPH::orderBy('uph_nama', 'ASC')->limit(100)->get();
                }
            }
            return response()->json($data);
        }
    }


}
