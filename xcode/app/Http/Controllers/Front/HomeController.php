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
use App\Models\Reward;
use App\Models\Slider;
use App\Models\Stores;
use App\Models\SubCategory;
use App\Models\UPH;
use App\Models\User;
use App\Models\Voucher;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class HomeController extends Controller
{


    public function index()
    {
        $view = 'myfront.index';
        $now = date('Y-m-d');
        $new_events = Event::leftjoin('users', 'event.created_by', '=', 'users.id')
            ->orderBy('event.created_at',"DESC")
            ->limit(5)
            ->get();
        $new_planner = User::leftjoin('user_has_role', 'user_has_role.user_id', '=', 'users.id')
            ->where('user_has_role.role_id',3)
            ->orderBy('users.created_at',"DESC")
            ->limit(5)
            ->get();


        $data = [
            'new_events' => $new_events,
            'new_planner' => $new_planner,
        ];

        return view($view, $data);
    }

    public function eventPlanner(Request $request){
        $view = 'myfront.planner.index';
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $planner = User::leftjoin('user_has_role', 'user_has_role.user_id', '=', 'users.id')
                ->where('users.name','LIKE','%'.$keyword.'%')
                ->where('user_has_role.role_id',3)
                ->paginate(10);
        }else{
            $planner = User::leftjoin('user_has_role', 'user_has_role.user_id', '=', 'users.id')
                ->where('user_has_role.role_id',3)
                ->paginate(10);
        }

        $data = [
            'planner' => $planner,
            'keyword' => $keyword
        ];

        return view($view, $data);

    }

    public function detailPlanner($id){
        $view = 'myfront.planner.detail_planner';

        $planner = User::find(decodeId($id));
        $other_planner =  User::leftjoin('user_has_role', 'user_has_role.user_id', '=', 'users.id')
            ->where('user_has_role.role_id',3)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $data = [
            'planner' => $planner,
            'other_planner' => $other_planner,
        ];

        return view($view, $data);
    }






}
