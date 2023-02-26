<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailKegiatanController;
use App\Http\Controllers\KegiatanController;
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

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('Login');
    Route::post('cek-login', 'cek_login')->name('CekLogin');
    Route::get('logout', 'logout')->name('LogOut');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['isAdmin'])->group(function () {
        Route::controller(KegiatanController::class)->group(function () {
            Route::get('kegiatan', 'daftar_kegiatan')->name('DaftarKegiatan');
            Route::post('tambah-kegiatan', 'tambah_kegiatan')->name('TambahKegiatan');
            Route::post('ubah-kegiatan/{id}', 'ubah_kegiatan')->name('UbahKegiatan');
            Route::get('hapus-kegiatan/{id}', 'hapus_kegiatan');
        });
        
        Route::controller(DetailKegiatanController::class)->group(function () {
            Route::get('detail-kegiatan/{slug}', 'detail_kegiatan')->name('DaftarKegiatan.DetailKegiatan');
            Route::post('tambah-detail-kegiatan', 'tambah_detail_kegiatan')->name('TambahDetailKegiatan');
            Route::post('ubah-detail-kegiatan/{id}', 'ubah_detail_kegiatan')->name('UbahDataDetailKegiatan');
            Route::get('hapus-detail-kegiatan/{id}', 'hapus_detail_kegiatan');            

            Route::get('cetak-catatan-hutang', 'export_input')->name('CetakCatatanHutang');
        });

        Route::controller(AuthController::class)->group(function () {
            Route::post('ubah-password', [AuthController::class, 'ubah_password'])->name('UbahPassword');
        });
    });
});