<?php

use App\Http\Controllers\Bendahara\BendaharaAlurKasController;
use App\Http\Controllers\Bendahara\BendaharaKategoriTransaksiController;
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
        Route::delete('/delete/{id}', [BendaharaKategoriTransaksiController::class, 'destroy']);
    });

    //Alur Kas
    Route::prefix('alur-kas')->group(function () {
        Route::get('/', [BendaharaAlurKasController::class, 'index']);
        Route::get('/show/{id}', [BendaharaAlurKasController::class, 'show']);
        Route::post('/create', [BendaharaAlurKasController::class, 'store']);
        Route::patch('/update/{id}', [BendaharaAlurKasController::class, 'update']);
        Route::delete('/delete/{id}', [BendaharaAlurKasController::class, 'destroy']);
    });

    //RAB 
    Route::prefix('rab')->group(function () {
        Route::get('/', [BendaharaRBAController::class, 'index']);
        Route::get('/show/{id}', [BendaharaRBAController::class, 'show']);
        Route::post('/create', [BendaharaRBAController::class, 'store']);
        Route::patch('/update/{id}', [BendaharaRBAController::class, 'update']);
        Route::delete('/delete/{id}', [BendaharaRBAController::class, 'destroy']);
    });
});
