<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',[\App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('register',[\App\Http\Controllers\API\AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout',[\App\Http\Controllers\API\AuthController::class, 'logout']);

    Route::group(['prefix' => 'dokter'], function () {
        Route::get('/',[\App\Http\Controllers\API\DokterController::class, 'index']);
    });
    Route::group(['prefix' => 'kunjungan'], function () {
        Route::get('/',[\App\Http\Controllers\API\KunjunganKonsultasiController::class, 'index']);
    });
    Route::group(['prefix' => 'hewan'], function () {
        Route::get('/',[\App\Http\Controllers\API\HewanController::class, 'index']);
        Route::get('/kategori',[\App\Http\Controllers\API\HewanController::class, 'kategoriHewan']);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('/profile',[\App\Http\Controllers\API\UserController::class, 'profile']);
        Route::post('/profile',[\App\Http\Controllers\API\UserController::class, 'updateProfile']);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('fcm', [\App\Http\Controllers\API\UserController::class,'updateFcmToken']);
        Route::get('hewan', [\App\Http\Controllers\API\UserController::class,'hewan']);
    });
    Route::group(['prefix' => 'konsultasi'], function () {
        Route::get('/', [\App\Http\Controllers\API\KonsultasiController::class,'index']);
        Route::get('{id}/chat', [\App\Http\Controllers\API\KonsultasiController::class,'chat']);
        Route::post('{id}/chat', [\App\Http\Controllers\API\KonsultasiController::class,'sendChat']);
        Route::post('/', [\App\Http\Controllers\API\KonsultasiController::class,'store']);
        Route::post('/{id}/kunjungan',[\App\Http\Controllers\API\KunjunganKonsultasiController::class, 'store']);
        Route::put('/{id}/closed',[\App\Http\Controllers\API\KonsultasiController::class, 'close']);
    });
    Route::group(['prefix' => 'kepemilikan'], function () {
        Route::post('/', [\App\Http\Controllers\API\KepemilikanController::class,'store']);
        Route::post('/{id}', [\App\Http\Controllers\API\KepemilikanController::class,'update']);
        Route::get('/', [\App\Http\Controllers\API\KepemilikanController::class,'index']);
        Route::delete('/{id}', [\App\Http\Controllers\API\KepemilikanController::class,'destroy']);
        Route::get('/{id}', [\App\Http\Controllers\API\KepemilikanController::class,'show']);
    });
});
