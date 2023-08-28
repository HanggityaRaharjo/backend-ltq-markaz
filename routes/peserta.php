<?php

use App\Http\Controllers\AdminCabang\AdminPembayaranController;
use App\Http\Controllers\AdminCabang\AdminProgramController;
use App\Http\Controllers\AdminCabang\AdminProgramHargaController;
use App\Http\Controllers\Peserta\PesertaBiodataController;
use App\Http\Controllers\Peserta\PesertaCutiController;
use App\Http\Controllers\Peserta\PesertaExamEssaiController;
use App\Http\Controllers\Peserta\PesertaExamPGController;
use App\Http\Controllers\Peserta\PesertaExamPraktikumController;
use App\Http\Controllers\Peserta\PesertaExamTypeController;
use App\Http\Controllers\Peserta\PesertaProgramPembayaranController;
use App\Http\Controllers\Peserta\PesertaRequestDayController;
use App\Http\Controllers\Peserta\PesertaUserCabangController;
use App\Http\Controllers\Peserta\PesertaUserLevelController;
use App\Http\Controllers\Peserta\PesertaUserPaketCntroller;
use App\Http\Controllers\Peserta\PesertaUserProgramController;
use App\Http\Controllers\Peserta\PesertaVerifikasiPembayaranController;
use App\Http\Controllers\SuperAdmin\SuperAdminCabangLembagaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('cabang')->group(function () {
    Route::get('/', [SuperAdminCabangLembagaController::class, 'GetDataCabang']);
});

//User Cabang
Route::prefix('user-cabang')->group(function () {
    Route::get('/', [PesertaUserCabangController::class, 'GetDataUserCabang']);
    Route::get('/show/{id}', [PesertaPesertaUserCabangController::class, 'ShowDataUserCabang']);
    Route::get('/by-user/{uuid}', [PesertaPesertaUserCabangController::class, 'GetDataCabangByUser']);
    Route::post('/create', [PesertaPesertaUserCabangController::class, 'CreateDataUserCabang']);
    Route::post('/update/{id}', [PesertaPesertaUserCabangController::class, 'UpdateDataUserCabang']);
    Route::post('/delete/{id}', [PesertaPesertaUserCabangController::class, 'DeleteGetDataUserCabang']);
});

//Biodata Peserta
Route::prefix('biodata')->group(function () {
    Route::get('/', [PesertaBiodataController::class, 'getbiodatapeserta']);
    Route::get('/show/{uuid}', [PesertaBiodataController::class, 'showbiodatapeserta']);
    Route::post('/create', [PesertaBiodataController::class, 'createbiodatapeserta']);
    Route::post('/update/{id}', [PesertaBiodataController::class, 'updatebiodatapeserta']);
    Route::post('/delete/{uuid}', [PesertaBiodataController::class, 'deletebiodatapeserta']);
});

//Program
Route::prefix('program')->group(function () {
    Route::get('/', [AdminProgramController::class, 'GetDataProgram']);
    Route::get('/show/{id}', [AdminProgramController::class, 'ShowDataProgram']);
    Route::get('/show/by-cabang/{id}', [AdminProgramController::class, 'ShowDataProgramByCabang']);
    Route::post('/create', [AdminProgramController::class, 'CreateDataProgram']);
    Route::post('/update/{id}', [AdminProgramController::class, 'UpdateDataProgram']);
    Route::post('/delete/{id}', [AdminProgramController::class, 'DeleteDataProgram']);
});

//UserProgram
Route::prefix('user-program')->group(function () {
    Route::get('/', [PesertaUserProgramController::class, 'GetDataUserProgram']);
    Route::get('/show/by-user/{uuid}', [PesertaUserProgramController::class, 'ShowDataByUuidUserProgram']);
    Route::get('/get/{uuid}', [PesertaUserProgramController::class, 'ShowDataUserProgram']);
    Route::post('/create', [PesertaUserProgramController::class, 'CreateDataUserProgram']);
    Route::post('/update/{id}', [PesertaUserProgramController::class, 'UpdateDataUserProgram']);
    Route::post('/delete/{id}', [PesertaUserProgramController::class, 'DeleteDataUserProgram']);
});

//Program Pembayaran
Route::prefix('program-pembayaran')->group(function () {
    Route::get('/', [PesertaProgramPembayaranController::class, 'GetDataProgramPembayaran']);
    Route::get('/show/{uuid}', [PesertaProgramPembayaranController::class, 'ShowDataProgramPembayaran']);
    Route::post('/create', [PesertaProgramPembayaranController::class, 'CreateDataProgramPembayaran']);
    Route::post('/update/{id}', [PesertaProgramPembayaranController::class, 'UpdateDataProgramPembayaran']);
    Route::post('/delete/{id}', [PesertaProgramPembayaranController::class, 'DeleteGetDataProgramPembayaran']);
});

//Program harga
Route::prefix('program-harga')->group(function () {
    Route::get('/', [AdminProgramHargaController::class, 'GetDataProgramHarga']);
    Route::get('/show/{id}', [AdminProgramHargaController::class, 'ShowDataProgramHarga']);
    Route::post('/create', [AdminProgramHargaController::class, 'CreateDataProgramHarga']);
    Route::post('/update/{id}', [AdminProgramHargaController::class, 'UpdateDataProgramHarga']);
    Route::post('/delete/{id}', [AdminProgramHargaController::class, 'DeleteGetDataProgramHarga']);
});

//Pembayaran
Route::prefix('pembayaran')->group(function () {
    Route::get('/', [AdminPembayaranController::class, 'GetDataPembayaran']);
    Route::get('/show/{id}', [AdminPembayaranController::class, 'ShowDataPembayaran']);
    Route::post('/create', [AdminPembayaranController::class, 'CreateDataPembayaran']);
    Route::post('/code/{id}', [AdminPembayaranController::class, 'GenerateCode']);
    Route::post('/update/{id}', [AdminPembayaranController::class, 'UpdateDataPembayaran']);
    Route::post('/delete/{id}', [AdminPembayaranController::class, 'DeleteGetDataPembayaran']);
});

//Exam Type
Route::prefix('exam-type')->group(function () {
    Route::get('/', [PesertaExamTypeController::class, 'GetDataExamType']);
    Route::get('/get/{id}', [PesertaExamTypeController::class, 'ShowDataExamType']);
    Route::get('/show/placement-test', [PesertaExamTypeController::class, 'ShowDataByExamTypeExamPG']);
    Route::post('/create', [PesertaExamTypeController::class, 'CreateDataExamType']);
    Route::post('/update/{id}', [PesertaExamTypeController::class, 'UpdateDataExamType']);
    Route::post('/delete/{id}', [PesertaExamTypeController::class, 'DeleteDataExamType']);
});

//Exam PG
Route::prefix('exampg')->group(function () {
    Route::get('/', [PesertaExamPGController::class, 'GetDataExamPG']);
    Route::get('/show/{id}', [PesertaExamPGController::class, 'ShowDataExamPG']);
    Route::post('/create', [PesertaExamPGController::class, 'CreateDataExamPG']);
    Route::post('/update/{id}', [PesertaExamPGController::class, 'UpdateDataExamPG']);
    Route::post('/delete/{id}', [PesertaExamPGController::class, 'DeleteDataExamPG']);
});

//UserLevel
Route::prefix('user-level')->group(function () {
    Route::get('/', [PesertaUserLevelController::class, 'GetDataUserLevel']);
    Route::get('/show/{uuid}', [PesertaUserLevelController::class, 'ShowDataUserLevel']);
    Route::post('/create', [PesertaUserLevelController::class, 'CreateDataUserLevel']);
    Route::post('/update/{id}', [PesertaUserLevelController::class, 'UpdateDataUserLevel']);
    Route::post('/delete/{id}', [PesertaUserLevelController::class, 'DeleteDataUserLevel']);
});

//Verifikasi Pembayaran
Route::prefix('verifikasi-pembayaran')->group(function () {
    Route::get('/', [PesertaVerifikasiPembayaranController::class, 'GetDataVerifikasiPembayaran']);
    Route::get('/show/{id}', [PesertaVerifikasiPembayaranController::class, 'ShowDataVerifikasiPembayaran']);
    Route::get('/show/by-user/{uuid}', [PesertaVerifikasiPembayaranController::class, 'ShowDataByUserVerifikasiPembayaran']);
    Route::post('/create', [PesertaVerifikasiPembayaranController::class, 'CreateDataVerifikasiPembayaran']);
    Route::post('/update/{id}', [PesertaVerifikasiPembayaranController::class, 'UpdateDataVerifikasiPembayaran']);
    Route::post('/delete/{id}', [PesertaVerifikasiPembayaranController::class, 'DeleteDataVerifikasiPembayaran']);
});

//Exam Essai
Route::prefix('examessai')->group(function () {
    Route::get('/', [PesertaExamEssaiController::class, 'GetDataExamEssai']);
    Route::get('/show/{id}', [PesertaExamEssaiController::class, 'ShowDataExamEssai']);
    Route::post('/create', [PesertaExamEssaiController::class, 'CreateDataExamEssai']);
    Route::post('/update/{id}', [PesertaExamEssaiController::class, 'UpdateDataExamEssai']);
    Route::post('/delete/{id}', [PesertaExamEssaiController::class, 'DeleteDataExamEssai']);
});

//Exam Praktikum
Route::prefix('examprak')->group(function () {
    Route::get('/', [PesertaExamPraktikumController::class, 'GetDataExamPraktikum']);
    Route::get('/show/{id}', [PesertaExamPraktikumController::class, 'ShowDataExamPraktikum']);
    Route::post('/create', [PesertaExamPraktikumController::class, 'CreateDataExamPraktikum']);
    Route::post('/update/{id}', [PesertaExamPraktikumController::class, 'UpdateDataExamPraktikum']);
    Route::post('/delete/{id}', [PesertaExamPraktikumController::class, 'DeleteDataExamPraktikum']);
});

//UserPaket
Route::prefix('userpaket')->group(function () {
    Route::get('/', [PesertaUserPaketCntroller::class, 'GetDataUserPaket']);
    Route::get('/show/{id}', [PesertaUserPaketCntroller::class, 'ShowDataUserPaket']);
    Route::post('/create', [PesertaUserPaketCntroller::class, 'CreateDataUserPaket']);
    Route::post('/update/{id}', [PesertaUserPaketCntroller::class, 'UpdateDataUserPaket']);
    Route::post('/delete/{id}', [PesertaUserPaketCntroller::class, 'DeleteDataUserPaket']);
});

//RequestDay
Route::prefix('requestday')->group(function () {
    Route::get('/', [PesertaRequestDayController::class, 'GetDataRequestDay']);
    Route::get('/show/{id}', [PesertaRequestDayController::class, 'ShowDataRequestDay']);
    Route::post('/create', [PesertaRequestDayController::class, 'CreateDataRequestDay']);
    Route::post('/update/{id}', [PesertaRequestDayController::class, 'UpdateDataRequestDay']);
    Route::post('/delete/{id}', [PesertaRequestDayController::class, 'DeleteDataRequestDay']);
});

//Cuti
Route::prefix('cuti')->group(function () {
    Route::get('/', [PesertaCutiController::class, 'GetDataCuti']);
    Route::get('/show/{id}', [PesertaCutiController::class, 'ShowDataCuti']);
    Route::post('/create', [PesertaCutiController::class, 'CreateDataCuti']);
    Route::post('/update/{id}', [PesertaCutiController::class, 'UpdateDataCuti']);
    Route::post('/delete/{id}', [PesertaCutiController::class, 'DeleteGetDataCuti']);
});

Route::prefix('user/show/by-uuid')->group(function () {
    Route::get('/{uuid}', [UserController::class, 'ShowDataByUuidPeserta']);
});
