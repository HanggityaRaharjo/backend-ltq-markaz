<?php

use App\Http\Controllers\Bendahara\BendaharaAlurKasController;
use App\Http\Controllers\Bendahara\BendaharaKategoriTransaksiController;
use App\Http\Controllers\Bendahara\BendaharaRab;
use App\Http\Controllers\Bendahara\BendaharaRabSubItem;
use App\Http\Controllers\Bendahara\BendaharaRabSubKegiatan;
use App\Http\Controllers\Bendahara\BendaharaRBAController;
use Illuminate\Support\Facades\Route;


// Middleware Dimatiin Dulu
Route::prefix('bendahara')->group(function () {

    //Kategori Transaksi
    Route::prefix('kategori')->group(function () {
        Route::get('/', [BendaharaKategoriTransaksiController::class, 'index']);
        Route::get('/show/{id}', [BendaharaKategoriTransaksiController::class, 'show']);
        Route::post('/create', [BendaharaKategoriTransaksiController::class, 'store']);
        Route::post('/update/{id}', [BendaharaKategoriTransaksiController::class, 'update']);
        Route::post('/delete/{id}', [BendaharaKategoriTransaksiController::class, 'destroy']);
    });

    //Alur Kas
    Route::prefix('alur-kas')->group(function () {
        Route::get('/', [BendaharaAlurKasController::class, 'index']);
        Route::get('/countpendapatan-perhari', [BendaharaAlurKasController::class, 'countPendapatanPerhari']);
        Route::get('/countpendapatan-perbulan', [BendaharaAlurKasController::class, 'countPendapatanPerbulan']);
        Route::get('/countpendapatan-pertahun', [BendaharaAlurKasController::class, 'countPendapatanPertahun']);
        Route::get('/countpengeluaran-perhari', [BendaharaAlurKasController::class, 'countPengeluaranPerhari']);
        Route::get('/countpengeluaran-perbulan', [BendaharaAlurKasController::class, 'countPengeluaranPerbulan']);
        Route::get('/countpengeluaran-pertahun', [BendaharaAlurKasController::class, 'countPengeluaranPertahun']);
        Route::get('/countlaba', [BendaharaAlurKasController::class, 'countLabaPerhari']);
        Route::get('/by-kategori/{kategori_transaksi}', [BendaharaAlurKasController::class, 'getByKategori']);
        Route::get('/show/{id}', [BendaharaAlurKasController::class, 'show']);
        Route::post('/by-tanggal', [BendaharaAlurKasController::class, 'getByTanggal']);
        Route::post('/by-tanggal-kategori', [BendaharaAlurKasController::class, 'getByTanggalKategori']);
        Route::post('/create', [BendaharaAlurKasController::class, 'store']);
        Route::post('/update/{id}', [BendaharaAlurKasController::class, 'update']);
        Route::post('/delete/{id}', [BendaharaAlurKasController::class, 'destroy']);
    });

    //SubItem
    Route::prefix('sub-item')->group(function () {
        Route::get('/', [BendaharaRabSubItem::class, 'getAllSubItem']);
        Route::get('/show/{id}', [BendaharaRabSubItem::class, 'getSubItemById']);
        Route::post('/create', [BendaharaRabSubItem::class, 'creatSubItem']);
        Route::post('/update/{id}', [BendaharaRabSubItem::class, 'updateSubItem']);
        Route::post('/delete/{id}', [BendaharaRabSubItem::class, 'destroySubItem']);
    });

    //SubKegiatan
    Route::prefix('sub-kegiatan')->group(function () {
        Route::get('/', [BendaharaRabSubKegiatan::class, 'getAllSubKegiatan']);
        Route::get('/show/{id}', [BendaharaRabSubKegiatan::class, 'getSubKegiatanById']);
        Route::post('/create', [BendaharaRabSubKegiatan::class, 'creatSubKegiatan']);
        Route::post('/update/{id}', [BendaharaRabSubKegiatan::class, 'updateSubKegiatan']);
        Route::post('/delete/{id}', [BendaharaRabSubKegiatan::class, 'destroySubKegiatan']);
    });

    //RAB
    Route::prefix('rab')->group(function () {
        Route::get('/', [BendaharaRab::class, 'getAllRab']);
        Route::get('/show/{id}', [BendaharaRab::class, 'getRabById']);
        Route::post('/create', [BendaharaRab::class, 'creatRab']);
        Route::post('/update/{id}', [BendaharaRab::class, 'updateRab']);
        Route::post('/delete/{id}', [BendaharaRab::class, 'destroyRab']);
    });


    //RAB Bendahara
    // Route::prefix('rab')->group(function () {
    //     Route::get('/', [BendaharaRBAController::class, 'index']);
    //     Route::get('/show/{id}', [BendaharaRBAController::class, 'show']);
    //     Route::post('/create', [BendaharaRBAController::class, 'store']);
    //     Route::patch('/update/{id}', [BendaharaRBAController::class, 'update']);
    //     Route::delete('/delete/{id}', [BendaharaRBAController::class, 'destroy']);
    // });
});
