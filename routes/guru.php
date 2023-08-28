<?php

use App\Http\Controllers\Guru\GuruAbsensiGuruController;
use App\Http\Controllers\Guru\GuruAbsensiPesertaController;
use App\Http\Controllers\Guru\GuruBiodataController;
use App\Http\Controllers\Guru\GuruCutiController;
use App\Http\Controllers\Guru\GuruInputNilaiSiswaController;
use App\Http\Controllers\Guru\GuruKelasController;
use App\Http\Controllers\Guru\GuruKurikulumController;
use App\Http\Controllers\Guru\GuruPetunjukPengajarController;
use App\Http\Controllers\Guru\GuruRaportSiswaController;
use Illuminate\Support\Facades\Route;

// Management Guru

Route::prefix('guru')->middleware('guru')->group(function () {
    //Biodata Guru
    Route::prefix('biodata-guru')->group(function () {
        Route::get('/', [GuruBiodataController::class, 'getbiodataguru']);
        Route::get('/show/{uuid}', [GuruBiodataController::class, 'showbiodataguru']);
        Route::post('/create', [GuruBiodataController::class, 'createbiodataguru']);
        Route::post('/update/{id}', [GuruBiodataController::class, 'updatebiodataguru']);
        Route::post('/delete/{uuid}', [GuruBiodataController::class, 'deletebiodataguru']);
        Route::post('/show/{uuid}', [GuruBiodataController::class, 'showbiodataguru']);
    });

    //Kelas
    Route::prefix('kelas')->group(function () {
        Route::get('/', [GuruKelasController::class, 'GetDataKelas']);
        Route::get('/show/{id}', [GuruKelasController::class, 'ShowDataKelas']);
        Route::post('/create', [GuruKelasController::class, 'CreateDataKelas']);
        Route::post('/update/{id}', [GuruKelasController::class, 'UpdateDataKelas']);
        Route::post('/delete/{id}', [GuruKelasController::class, 'DeleteDataKelas']);
    });

    //Absensi Peserta
    Route::prefix('absensi-peserta')->group(function () {
        Route::get('/', [GuruAbsensiPesertaController::class, 'GetDataAbsensiPeserta']);
        Route::get('/show/{id}', [GuruAbsensiPesertaController::class, 'ShowDataAbsensiPeserta']);
        Route::post('/create', [GuruAbsensiPesertaController::class, 'CreateDataAbsensiPeserta']);
        Route::post('/update/{id}', [GuruAbsensiPesertaController::class, 'UpdateDataAbsensiPeserta']);
        Route::post('/delete/{id}', [GuruAbsensiPesertaController::class, 'DeleteDataAbsensiPeserta']);
    });

    //Absensi Guru
    Route::prefix('absensi-guru')->group(function () {
        Route::get('/', [GuruAbsensiGuruController::class, 'GetDataAbsensiGuru']);
        Route::get('/show/{id}', [GuruAbsensiGuruController::class, 'ShowDataAbsensiGuru']);
        Route::post('/create', [GuruAbsensiGuruController::class, 'CreateDataAbsensiGuru']);
        Route::post('/update/{id}', [GuruAbsensiGuruController::class, 'UpdateDataAbsensiGuru']);
        Route::post('/delete/{id}', [GuruAbsensiGuruController::class, 'DeleteDataAbsensiGuru']);
    });

    //Cuti Guru
    Route::prefix('cuti-guru')->group(function () {
        Route::get('/', [GuruCutiController::class, 'GetDataCuti']);
        Route::get('/show/{id}', [GuruCutiController::class, 'ShowDataCuti']);
        Route::post('/create/{uuid}', [GuruCutiController::class, 'CreateDataCuti']);
        Route::post('/update/{id}', [GuruCutiController::class, 'UpdateDataCuti']);
        Route::post('/delete/{id}', [GuruCutiController::class, 'DeleteDataCuti']);
    });
    //Input NIlai
    Route::prefix('input-nilai')->group(function () {
        Route::get('/', [GuruInputNilaiSiswaController::class, 'GetDataNilaiSiswa']);
        Route::get('/show/{id}', [GuruInputNilaiSiswaController::class, 'ShowDataNilaiSiswa']);
        Route::post('/create', [GuruInputNilaiSiswaController::class, 'CreateDataNilaiSiswa']);
        Route::post('/update/{id}', [GuruInputNilaiSiswaController::class, 'UpdateDataNilaiSiswa']);
        Route::post('/delete/{id}', [GuruInputNilaiSiswaController::class, 'DeleteDataNilaiSiswa']);
    });
    //Raport Siswa
    Route::prefix('raport')->group(function () {
        Route::get('/', [GuruRaportSiswaController::class, 'GetDataRaport']);
        Route::get('/show/{id}', [GuruRaportSiswaController::class, 'ShowDataRaport']);
        Route::post('/create', [GuruRaportSiswaController::class, 'CreateDataRaport']);
        Route::post('/update/{id}', [GuruRaportSiswaController::class, 'UpdateDataRaport']);
        Route::post('/delete/{id}', [GuruRaportSiswaController::class, 'DeleteDataRaport']);
    });
    //Kurikulum
    Route::prefix('kurikulum')->group(function () {
        Route::get('/', [GuruKurikulumController::class, 'GetDataKurikulum']);
        Route::get('/show/{id}', [GuruKurikulumController::class, 'ShowDataKurikulum']);
        Route::post('/create', [GuruKurikulumController::class, 'CreateDataKurikulum']);
        Route::post('/update/{id}', [GuruKurikulumController::class, 'UpdateDataKurikulum']);
        Route::post('/delete/{id}', [GuruKurikulumController::class, 'DeleteDataKurikulum']);
    });
    //Petunjuk Pengajar
    Route::prefix('petunjuk-pengajar')->group(function () {
        Route::get('/', [GuruPetunjukPengajarController::class, 'GetDataPetenjukPenganjar']);
        Route::get('/show/{id}', [GuruPetunjukPengajarController::class, 'ShowDataPetenjukPenganjar']);
        Route::post('/create', [GuruPetunjukPengajarController::class, 'CreateDataPetenjukPenganjar']);
        Route::post('/update/{id}', [GuruPetunjukPengajarController::class, 'UpdateDataPetenjukPenganjar']);
        Route::post('/delete/{id}', [GuruPetunjukPengajarController::class, 'DeleteDataPetenjukPenganjar']);
    });
});
