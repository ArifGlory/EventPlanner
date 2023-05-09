<?php


use App\Http\Controllers\Back\StoreController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\SubCategoryController;
use App\Http\Controllers\Back\ProductController;
use App\Http\Controllers\Back\VoucherController;
use App\Http\Controllers\Back\MissionController;
use App\Http\Controllers\Back\RewardController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\LogController;
use App\Http\Controllers\Back\LogSaldoPointController;
use App\Http\Controllers\Back\ProfileController;
use App\Http\Controllers\Back\SettingController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MissionUserController;
use App\Http\Controllers\Front\ProfileUserController;
use App\Http\Controllers\Front\Web3LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index']);
Route::get('/pelaku-usaha', [HomeController::class, 'pelakuUsaha']);

Route::get('/mission', [MissionUserController::class, 'index']);
Route::get('/mission/detail/{id}', [MissionUserController::class, 'detailMission']);
Route::get('/mission/join/{id}', [MissionUserController::class, 'joinMission'])->middleware('useraccess');
Route::get('/mission/submission/{id}', [MissionUserController::class, 'submission'])->middleware('useraccess');
Route::post('/mission/submission/store', [MissionUserController::class, 'storeSubmission'])->middleware('useraccess');

Route::get('/reward', [HomeController::class, 'reward']);
Route::get('/detail-reward/{id}', [HomeController::class, 'detailReward']);
Route::get('/leaderboard', [HomeController::class, 'leaderboard']);


Route::get('/produk', [HomeController::class, 'produk']);
Route::get('/detail-produk/{id}', [HomeController::class, 'detailProduk']);
Route::get('/produk-link/{id}', [HomeController::class, 'produkLink'])->middleware('useraccess');

Route::get('/voucher', [HomeController::class, 'voucher']);
Route::get('/detail-voucher/{id}', [HomeController::class, 'detailVoucher']);
Route::get('/use-voucher/{id}', [HomeController::class, 'useVoucher'])->middleware('useraccess');

Route::get('/web3-login-message', [Web3LoginController::class, 'message'])->name('web3.message');
Route::post('/web3-login-verify', [Web3LoginController::class, 'verify'])->name('web3.verify');

Route::group(['prefix' => 'user', 'middleware' => ['user_and_store']], function () {
    Route::get('/', [ProfileUserController::class, 'index']);
    Route::get('/become-store', [ProfileUserController::class, 'addRoleStore']);
});

Route::get('auth-logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('auth-logout');
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "Cache is cleared";
});
Route::group(['prefix' => 'main', 'middleware' => ['web', 'auth']], function () {
    Route::get('/testss', function () {
        dd(\App\Models\User::whereHas('fitur', function ($q) {
            $q->where('nama_fitur', '=', 'Penebusan Puber');
        })->get());
        /*
         * Gate check untuk layanan dan fitur
         * \Illuminate\Support\Facades\Gate::check('layanan', ['Hallo Medik Vet']),//Mengecek layanan yang dibolehkan oleh user tertentu
         * \Illuminate\Support\Facades\Gate::check('fitur', ['Data Alokasi'])//Mengecek fitur yang dibolehkan oleh user tertentu
         *
         * ! sementara helper berikut digunakan untuk di controller
         * $this->authorize('layanan', ['Hallo Medik Vet']);
         * $this->authorize('fitur', ['Data Alokasi']);
         *
         * Di bawah ini untuk directive blade apabila digunakan pada front end
         * @can('fitur', ['Data Alokasi'])
         * @can('layanan', ['Hallo Medik Vet'])
         * */
    });
    Route::middleware(['cekaktif'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
});

Route::group(['prefix' => 'main', 'middleware' => ['web', 'auth']], function () {
    Route::middleware(['cekaktif'])->group(function () {
        //Route::post('editor/image_upload', [BackController::class, 'uploadImageCKEditor'])->name('uploadviackeditor');

        Route::group(['prefix' => 'aktivitas'], function () {
            Route::get('/', [LogController::class, 'index']);
            Route::get('data', [LogController::class, 'data']);
            Route::delete('delete/{id}', [LogController::class, 'destroy']);
            Route::post('bulkDelete', [LogController::class, 'bulkDelete']);
        });

        Route::group(['prefix' => 'transaksi-point'], function () {
            Route::get('/', [LogSaldoPointController::class, 'index']);
            Route::get('data', [LogSaldoPointController::class, 'data']);
            Route::get('form', [LogSaldoPointController::class, 'form']);
            Route::post('create', [LogSaldoPointController::class, 'store']);
            Route::get('detail/{id}', [LogSaldoPointController::class, 'show']);
        });

        Route::group(['prefix' => 'pengguna'], function () {
            Route::get('/', [UserController::class, 'index'])->name('user');
            Route::get('/find', [UserController::class, 'find']);
            Route::get('data', [UserController::class, 'data']);
            Route::delete('delete/{id}', [UserController::class, 'destroy']);
            Route::post('bulkDelete', [UserController::class, 'bulkDelete']);
            Route::post('bulkStatus', [UserController::class, 'bulkStatus']);
            Route::get('form', [UserController::class, 'form'])->name('user.form');
            Route::post('create', [UserController::class, 'store']);
            Route::get('edit/{id}', [UserController::class, 'edit']);
            Route::put('update/{id}', [UserController::class, 'update']);
            Route::get('detail/{id}', [UserController::class, 'show']);
            Route::get('update-status', [UserController::class, 'updateStatus']);
            if (useSoftDelete() == true) {
                Route::delete('delete-permanen/{id}', [UserController::class, 'deletePermanen']);
                Route::post('bulkDelete-permanen', [UserController::class, 'bulkDeletePermanen']);
                Route::get('restore/{id}', [UserController::class, 'restore']);
                Route::post('bulkRestore', [UserController::class, 'bulkRestore']);
            }
        });

        Route::group(['prefix' => 'stores'], function () {
            Route::get('/', [StoreController::class, 'index']);
            Route::get('data', [StoreController::class, 'data']);
            Route::get('form', [StoreController::class, 'form']);
            Route::post('create', [StoreController::class, 'store']);
            Route::put('update/{id}', [StoreController::class, 'update']);
            Route::get('edit/{id}', [StoreController::class, 'edit']);
            Route::delete('delete/{id}', [StoreController::class, 'destroy']);
            Route::get('detail/{id}', [StoreController::class, 'show']);
            Route::get('update-status', [StoreController::class, 'updateStatus']);
            Route::post('bulkStatus', [StoreController::class, 'bulkStatus']);
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('data', [CategoryController::class, 'data']);
            Route::get('form', [CategoryController::class, 'form']);
            Route::post('create', [CategoryController::class, 'store']);
            Route::put('update/{id}', [CategoryController::class, 'update']);
            Route::get('edit/{id}', [CategoryController::class, 'edit']);
            Route::delete('delete/{id}', [CategoryController::class, 'destroy']);
            Route::get('detail/{id}', [CategoryController::class, 'show']);
            Route::get('update-status', [CategoryController::class, 'updateStatus']);
            Route::post('bulkStatus', [CategoryController::class, 'bulkStatus']);
        });

        Route::group(['prefix' => 'subcategory'], function () {
            Route::get('/', [SubCategoryController::class, 'index']);
            Route::get('data', [SubCategoryController::class, 'data']);
            Route::get('form', [SubCategoryController::class, 'form']);
            Route::post('create', [SubCategoryController::class, 'store']);
            Route::put('update/{id}', [SubCategoryController::class, 'update']);
            Route::get('edit/{id}', [SubCategoryController::class, 'edit']);
            Route::delete('delete/{id}', [SubCategoryController::class, 'destroy']);
            Route::get('detail/{id}', [SubCategoryController::class, 'show']);
            Route::get('update-status', [SubCategoryController::class, 'updateStatus']);
            Route::post('bulkStatus', [SubCategoryController::class, 'bulkStatus']);
        });

        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('data', [ProductController::class, 'data']);
            Route::get('form', [ProductController::class, 'form']);
            Route::post('create', [ProductController::class, 'store']);
            Route::put('update/{id}', [ProductController::class, 'update']);
            Route::get('edit/{id}', [ProductController::class, 'edit']);
            Route::delete('delete/{id}', [ProductController::class, 'destroy']);
            Route::get('detail/{id}', [ProductController::class, 'show']);
            Route::get('update-status', [ProductController::class, 'updateStatus']);
            Route::post('bulkStatus', [ProductController::class, 'bulkStatus']);
        });

        Route::group(['prefix' => 'voucher'], function () {
            Route::get('/', [VoucherController::class, 'index']);
            Route::get('data', [VoucherController::class, 'data']);
            Route::get('form', [VoucherController::class, 'form']);
            Route::post('create', [VoucherController::class, 'store']);
            Route::put('update/{id}', [VoucherController::class, 'update']);
            Route::get('edit/{id}', [VoucherController::class, 'edit']);
            Route::delete('delete/{id}', [VoucherController::class, 'destroy']);
            Route::get('detail/{id}', [VoucherController::class, 'show']);
            Route::get('update-status', [VoucherController::class, 'updateStatus']);
            Route::post('bulkStatus', [VoucherController::class, 'bulkStatus']);
        });

        Route::group(['prefix' => 'mission'], function () {
            Route::get('/', [MissionController::class, 'index']);
            Route::get('data', [MissionController::class, 'data']);
            Route::get('data-submission', [MissionController::class, 'dataSubmission']);
            Route::get('form', [MissionController::class, 'form']);
            Route::post('create', [MissionController::class, 'store']);
            Route::put('update/{id}', [MissionController::class, 'update']);
            Route::get('edit/{id}', [MissionController::class, 'edit']);
            Route::delete('delete/{id}', [MissionController::class, 'destroy']);
            Route::get('detail/{id}', [MissionController::class, 'show']);
            Route::get('update-status', [MissionController::class, 'updateStatus']);
            Route::post('bulkStatus', [MissionController::class, 'bulkStatus']);
            Route::get('submission/accept/{id}', [MissionController::class, 'acceptSubmission']);
            Route::get('submission/decline/{id}', [MissionController::class, 'declineSubmission']);
            Route::post('submission/decline/store', [MissionController::class, 'storeDeclineSubmission']);
        });

        Route::get('profil', [ProfileController::class, 'profil']);
        Route::get('side-profil', [ProfileController::class, 'sideProfil']);
        Route::put('update-profil', [ProfileController::class, 'updateProfil']);
        Route::get('ubah-password', [ProfileController::class, 'ubahPassword']);
        Route::put('update-password', [ProfileController::class, 'updatePassword']);
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::put('update-settings', [SettingController::class, 'updateAll']);
        Route::get('log-saya', [ProfileController::class, 'logSaya']);
        Route::get('data-log-saya/{id}', [ProfileController::class, 'logsDataSaya']);
        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        Route::group(['prefix' => 'reward'], function () {
            Route::get('/', [RewardController::class, 'index']);
            Route::get('data', [RewardController::class, 'data']);
            Route::get('form', [RewardController::class, 'form']);
            Route::post('create', [RewardController::class, 'store']);
            Route::put('update/{id}', [RewardController::class, 'update']);
            Route::get('edit/{id}', [RewardController::class, 'edit']);
            Route::delete('delete/{id}', [RewardController::class, 'destroy']);
            Route::get('detail/{id}', [RewardController::class, 'show']);
            Route::get('update-status', [RewardController::class, 'updateStatus']);
            Route::post('bulkStatus', [RewardController::class, 'bulkStatus']);
        });


    });
});


require __DIR__ . '/auth.php';
