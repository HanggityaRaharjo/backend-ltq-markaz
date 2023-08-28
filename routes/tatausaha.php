<?php

use App\Http\Controllers\TataUsaha\TataUsahaBarangController;
use App\Http\Controllers\TataUsaha\TataUsahaBarangKeluarController;
use App\Http\Controllers\TataUsaha\TataUsahaBarangMasukController;
use App\Http\Controllers\TataUsaha\TataUsahaBiodataController;
use App\Http\Controllers\TataUsaha\TataUsahaCutiController;
use App\Http\Controllers\TataUsaha\TataUsahaDPPController;
use App\Http\Controllers\TataUsaha\TataUsahaKonsumenController;
use App\Http\Controllers\TataUsaha\TataUsahaPembayaranBarangController;
use App\Http\Controllers\TataUsaha\TataUsahaSPPController;
use Illuminate\Support\Facades\Route;

Route::prefix('tata-usaha')->middleware('tatausaha')->group(function () {
    // Management Tata Usaha

    //Biodata Tata Usaha
    Route::prefix('biodata-tatausaha')->group(function () {
        Route::get('/', [TataUsahaBiodataController::class, 'getbiodatatatausaha']);
        Route::get('/show/{uuid}', [TataUsahaBiodataController::class, 'showbiodatatatausaha']);
        Route::post('/create', [TataUsahaBiodataController::class, 'createbiodatatatausaha']);
        Route::post('/update/{id}', [TataUsahaBiodataController::class, 'updatebiodatatatausaha']);
        Route::post('/delete/{uuid}', [TataUsahaBiodataController::class, 'deletebiodatatatausaha']);
        Route::post('/show/{uuid}', [TataUsahaBiodataController::class, 'showbiodatatatausaha']);
    });

    //Cuti Tata Usaha
    Route::prefix('cuti-tatausaha')->group(function () {
        Route::get('/', [TataUsahaCutiController::class, 'GetDataCuti']);
        Route::get('/show/{id}', [TataUsahaCutiController::class, 'ShowDataCuti']);
        Route::post('/create/{uuid}', [TataUsahaCutiController::class, 'CreateDataCuti']);
        Route::post('/update/{id}', [TataUsahaCutiController::class, 'UpdateDataCuti']);
        Route::post('/delete/{id}', [TataUsahaCutiController::class, 'DeleteDataCuti']);
    });

    //SPP
    Route::prefix('spp')->group(function () {
        Route::get('/', [TataUsahaSPPController::class, 'GetDataSpp']);
        Route::get('/show/{id}', [TataUsahaSPPController::class, 'ShowDataSpp']);
        Route::post('/create', [TataUsahaSPPController::class, 'CreateDataSpp']);
        Route::post('/update/{id}', [TataUsahaSPPController::class, 'UpdateDataSpp']);
        Route::post('/delete/{id}', [TataUsahaSPPController::class, 'DeleteDataSpp']);
    });

    //DPP
    Route::prefix('dpp')->group(function () {
        Route::get('/', [TataUsahaDPPController::class, 'GetDataDpp']);
        Route::get('/show/{id}', [TataUsahaDPPController::class, 'ShowDataDpp']);
        Route::post('/create', [TataUsahaDPPController::class, 'CreateDataDpp']);
        Route::post('/update/{id}', [TataUsahaDPPController::class, 'UpdateDataDpp']);
        Route::post('/delete/{id}', [TataUsahaDPPController::class, 'DeleteDataDpp']);
    });

    //Konsumen
    Route::prefix('konsumen')->group(function () {
        Route::get('/', [TataUsahaKonsumenController::class, 'GetDataKonsumen']);
        Route::get('/show/{id}', [TataUsahaKonsumenController::class, 'ShowDataKonsumen']);
        Route::post('/create', [TataUsahaKonsumenController::class, 'CreateDataKonsumen']);
        Route::post('/update/{id}', [TataUsahaKonsumenController::class, 'UpdateDataKonsumen']);
        Route::post('/delete/{id}', [TataUsahaKonsumenController::class, 'DeleteDataKonsumen']);
    });

    //Barang
    Route::prefix('barang')->group(function () {
        Route::get('/', [TataUsahaBarangController::class, 'GetDataBarang']);
        Route::get('/show/{id}', [TataUsahaBarangController::class, 'ShowDataBarang']);
        Route::post('/create', [TataUsahaBarangController::class, 'CreateDataBarang']);
        Route::post('/update/{id}', [TataUsahaBarangController::class, 'UpdateDataBarang']);
        Route::post('/delete/{id}', [TataUsahaBarangController::class, 'DeleteDataBarang']);
    });

    //Barang Masuk
    Route::prefix('barang-masuk')->group(function () {
        Route::get('/', [TataUsahaBarangMasukController::class, 'GetDataBarangMasuk']);
        Route::get('/show/{id}', [TataUsahaBarangMasukController::class, 'ShowDataBarangMasuk']);
        Route::post('/create', [TataUsahaBarangMasukController::class, 'CreateDataBarangMasuk']);
        Route::post('/update/{id}', [TataUsahaBarangMasukController::class, 'UpdateDataBarangMasuk']);
        Route::post('/delete/{id}', [TataUsahaBarangMasukController::class, 'DeleteDataBarangMasuk']);
    });

    //Barang Keluar
    Route::prefix('barang-masuk')->group(function () {
        Route::get('/', [TataUsahaBarangKeluarController::class, 'GetDataBarangKeluar']);
        Route::get('/show/{id}', [TataUsahaBarangKeluarController::class, 'ShowDataBarangKeluar']);
        Route::post('/create', [TataUsahaBarangKeluarController::class, 'CreateDataBarangKeluar']);
        Route::post('/update/{id}', [TataUsahaBarangKeluarController::class, 'UpdateDataBarangKeluar']);
        Route::post('/delete/{id}', [TataUsahaBarangKeluarController::class, 'DeleteDataBarangKeluar']);
    });

    //Pembayaran
    Route::prefix('pembayaran-barang')->group(function () {
        Route::get('/', [TataUsahaPembayaranBarangController::class, 'GetDataPembayranBarang']);
        Route::get('/show/{id}', [TataUsahaPembayaranBarangController::class, 'ShowDataPembayranBarang']);
        Route::post('/create', [TataUsahaPembayaranBarangController::class, 'CreateDataPembayranBarang']);
        Route::post('/update/{id}', [TataUsahaPembayaranBarangController::class, 'UpdateDataPembayranBarang']);
        Route::post('/delete/{id}', [TataUsahaPembayaranBarangController::class, 'DeleteDataPembayranBarang']);
    });
});
