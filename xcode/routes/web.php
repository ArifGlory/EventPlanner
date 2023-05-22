<?php


use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\EventController;
use App\Http\Controllers\Back\BeritaController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\LogController;
use App\Http\Controllers\Back\ProfileController;
use App\Http\Controllers\Back\SettingController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\EventUserController;
use App\Http\Controllers\Front\BeritaUserController;
use App\Http\Controllers\Front\ProfileUserController;
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
Route::get('/planner', [HomeController::class, 'eventPlanner']);
Route::get('/planner/detail/{id}', [HomeController::class, 'detailPlanner']);

Route::get('/event', [EventUserController::class, 'index']);
Route::get('/event/detail/{id}', [EventUserController::class, 'detailEvent']);
Route::get('/event/distribution', [EventUserController::class, 'eventDistribution']);
Route::post('/event/buy', [EventUserController::class, 'buyTicket'])->middleware('useraccess');
Route::post('/event/buy/store', [EventUserController::class, 'storePurchase'])->middleware('useraccess');

Route::get('/purchase/detail/{id}', [EventUserController::class, 'purchaseDetail']);
Route::post('/purchase/upload/payment', [EventUserController::class, 'uploadPaymentProve']);

Route::get('/berita', [BeritaUserController::class, 'index']);
Route::get('/berita/detail/{id}', [BeritaUserController::class, 'detail']);



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


        Route::group(['prefix' => 'event'], function () {
            Route::get('/', [EventController::class, 'index']);
            Route::get('data', [EventController::class, 'data']);
            Route::get('form', [EventController::class, 'form']);
            Route::post('create', [EventController::class, 'store']);
            Route::put('update/{id}', [EventController::class, 'update']);
            Route::get('edit/{id}', [EventController::class, 'edit']);
            Route::delete('delete/{id}', [EventController::class, 'destroy']);
            Route::get('detail/{id}', [EventController::class, 'show']);
            Route::get('update-status', [EventController::class, 'updateStatus']);
            Route::post('bulkStatus', [EventController::class, 'bulkStatus']);
        });

        Route::group(['prefix' => 'berita'], function () {
            Route::get('/', [BeritaController::class, 'index']);
            Route::get('data', [BeritaController::class, 'data']);
            Route::get('form', [BeritaController::class, 'form']);
            Route::post('create', [BeritaController::class, 'store']);
            Route::put('update/{id}', [BeritaController::class, 'update']);
            Route::get('edit/{id}', [BeritaController::class, 'edit']);
            Route::delete('delete/{id}', [BeritaController::class, 'destroy']);
            Route::get('detail/{id}', [BeritaController::class, 'show']);
            Route::get('update-status', [BeritaController::class, 'updateStatus']);
            Route::post('bulkStatus', [BeritaController::class, 'bulkStatus']);
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


    });
});


require __DIR__ . '/auth.php';
