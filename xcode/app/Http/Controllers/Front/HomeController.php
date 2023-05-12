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


        $data = [
            'new_events' => $new_events,
            /*'new_voucher' => Voucher::leftjoin('store', 'store.store_id', '=', 'voucher.store_id')
                ->where('voucher.voucher_end_date','>=',$now)
                ->orderBy('voucher_id',"DESC")
                ->limit(5)
                ->get(),*/
        ];

        return view($view, $data);
    }

    public function leaderboard(){
        $view = 'myfront.leaderboard';
        $leaderboard = User::select(
            'name','email','saldo_point','foto','wallet_address'
            )
            ->where('level','user')
            ->orderBy('saldo_point',"DESC")
            ->paginate(10);

        $data = [
            'leaderboard' => $leaderboard,
        ];

        return view($view, $data);
    }

    public function reward(Request $request){
        $view = 'myfront.reward';
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $reward = Reward::where('reward_status',1)
                ->where('reward_name','LIKE','%'.$keyword.'%')
                ->paginate(10);
        }else{
            $reward = Reward::where('reward_status',1)
                ->paginate(10);
        }

        $data = [
            'reward' => $reward,
            'keyword' => $keyword
        ];

        return view($view, $data);
    }

    public function detailReward($id){
        $reward = Reward::find(decodeId($id));

        $other_reward =  Reward::inRandomOrder()
            ->limit(3)
            ->get();
        $view = 'myfront.detail_reward';

        $data = [
            'reward' => $reward,
            'other_reward' => $other_reward,
        ];

        return view($view, $data);
    }

    public function produk(Request $request){
        $view = 'myfront.produk_usaha';
        $now = date('Y-m-d');
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $produk = Product::leftjoin('store', 'store.store_id', '=', 'product.store_id')
                ->leftjoin('master_sub_category', 'master_sub_category.subcategory_id', '=', 'product.subcategory_id')
                ->where('product.product_discount_end_date','>=',$now)
                ->where('product.product_name','LIKE','%'.$keyword.'%')
                ->paginate(10);
        }else{
            $produk = Product::leftjoin('store', 'store.store_id', '=', 'product.store_id')
                ->leftjoin('master_sub_category', 'master_sub_category.subcategory_id', '=', 'product.subcategory_id')
                ->where('product.product_discount_end_date','>=',$now)
                ->paginate(10);
        }

        $data = [
            'produk' => $produk,
            'keyword' => $keyword
        ];

        return view($view, $data);
    }

    public function detailProduk($id){
        $product = Product::leftjoin('store', 'store.store_id', '=', 'product.store_id')
            ->leftjoin('master_sub_category', 'master_sub_category.subcategory_id', '=', 'product.subcategory_id')
            ->where('product.product_id',decodeId($id))
            ->first();
        $tags = explode(",",$product->product_tags);
        $some_category = SubCategory::inRandomOrder()
            ->limit(10)
            ->get();
        $other_product =  Product::leftjoin('store', 'store.store_id', '=', 'product.store_id')
            ->inRandomOrder()
            ->limit(3)
            ->get();
        $view = 'myfront.detail_produk';

        $data = [
            'product' => $product,
            'tags' => $tags,
            'some_category' => $some_category,
            'other_product' => $other_product,
        ];

        return view($view, $data);
    }

    public function produkLink($id){
        $product = Product::find(decodeId($id));

        if ($product->product_url){
            return Redirect::to($product->product_url);
        }else{
            $msgerror = 'Mohon maaf link produk sedang bermasalah, coba lagi nanti ';
            return res500(\request()->ajax(), $msgerror);
        }
    }

    public function pelakuUsaha(Request $request){
        $view = 'myfront.pelaku_usaha';
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $stores = Stores::where('store.store_name','LIKE','%'.$keyword.'%')
                ->paginate(10);
        }else{
            $stores = Stores::paginate(10);
        }

        $data = [
            'stores' => $stores,
            'keyword' => $keyword
        ];

        return view($view, $data);
    }

    public function voucher(Request $request){
        $view = 'myfront.voucher';
        $now = date('Y-m-d');
        $keyword = "";

        if ($request->input('search')){
            $keyword = $request->input('search');
            $voucher = Voucher::leftjoin('store', 'store.store_id', '=', 'voucher.store_id')
                ->where('voucher.voucher_end_date','>=',$now)
                ->where('voucher.voucher_name','LIKE','%'.$keyword.'%')
                ->paginate(10);
        }else{
            $voucher = Voucher::leftjoin('store', 'store.store_id', '=', 'voucher.store_id')
                ->where('voucher.voucher_end_date','>=',$now)
                ->paginate(10);
        }

        $data = [
            'voucher' => $voucher,
            'keyword' => $keyword
        ];

        return view($view, $data);
    }

    public function detailVoucher($id){
        $voucher = Voucher::leftjoin('store', 'store.store_id', '=', 'voucher.store_id')
            ->where('voucher_id',decodeId($id))
            ->first();
        $tags = explode(",",$voucher->voucher_tags);
        $some_category = SubCategory::inRandomOrder()
            ->limit(10)
            ->get();
        $other_voucher =  Voucher::leftjoin('store', 'store.store_id', '=', 'voucher.store_id')
            ->inRandomOrder()
            ->limit(3)
            ->get();
        $view = 'myfront.detail_voucher';

        $data = [
            'voucher' => $voucher,
            'tags' => $tags,
            'some_category' => $some_category,
            'other_voucher' => $other_voucher,
        ];

        return view($view, $data);
    }

    public function useVoucher($id){
        $voucher = Voucher::find(decodeId($id));

        if ($voucher->voucher_url){
            return Redirect::to($voucher->voucher_url);
        }else{
            $msgerror = 'Mohon maaf link voucher sedang bermasalah, coba lagi nanti ';
            return res500(\request()->ajax(), $msgerror);
        }
    }





}
