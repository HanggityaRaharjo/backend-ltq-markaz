<?php

use App\Http\Controllers\AdminCabang\AdminFormulirController;
use App\Http\Controllers\AdminCabang\AdminFormulirInputController;
use App\Http\Controllers\AdminCabang\AdminPaketController;
use App\Http\Controllers\AdminCabang\AdminProfileCabangController;
use App\Http\Controllers\AdminCabang\AdminProgramController;
use App\Http\Controllers\AdminCabang\AdminRoleController;
use App\Http\Controllers\Peserta\AdminProgramDayController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admincabang')->middleware('admincabang')->group(function () {
    //User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'get_user']);
        Route::get('/show/{id}', [UserController::class, 'ShowDataProfileCabang']);
        Route::post('/create', [UserController::class, 'CreateUserRole']);
        Route::post('/update/{id}', [UserController::class, 'update_user']);
        Route::get('/active', [UserController::class, 'get_user_active']);
    });

    //Profile Cabang
    Route::prefix('profile')->group(function () {
        Route::get('/', [AdminProfileCabangController::class, 'GetDataProfileCabang']);
        Route::get('/show/{id}', [AdminProfileCabangController::class, 'ShowDataProfileCabang']);
        Route::post('/create', [AdminProfileCabangController::class, 'CreateDataProfileCabang']);
        Route::post('/update/{id}', [AdminProfileCabangController::class, 'UpdateDataProfileCabang']);
        Route::post('/delete/{id}', [AdminProfileCabangController::class, 'DeleteDataProfileCabang']);
    });

    //Role
    Route::prefix('role')->group(function () {
        Route::get('/', [AdminRoleController::class, 'GetDataRole']);
        Route::get('/show/{id}', [AdminRoleController::class, 'ShowDataRole']);
        Route::post('/create', [AdminRoleController::class, 'CreateDataRole']);
        Route::post('/create/akun', [AdminRoleController::class, 'CreateDataRole']);
        Route::get('/show/{id}', [AdminRoleController::class, 'ShowDataRole']);
        Route::post('/update/{id}', [AdminRoleController::class, 'UpdateDataRole']);
        Route::post('/delete/{id}', [AdminRoleController::class, 'DeleteDataRole']);
    });

    //Formulir
    Route::prefix('formulir')->group(function () {
        Route::get('/', [AdminFormulirController::class, 'GetDataFormulir']);
        Route::get('/show/{id}', [AdminFormulirController::class, 'ShowDataFormulir']);
        Route::post('/create', [AdminFormulirController::class, 'CreateDataFormulir']);
        Route::post('/update/{id}', [AdminFormulirController::class, 'UpdateDataFormulir']);
        Route::post('/delete/{id}', [AdminFormulirController::class, 'DeleteDataFormulir']);
    });

    //Formulir Input
    Route::prefix('formulirinput')->group(function () {
        Route::get('/', [AdminFormulirInputController::class, 'GetDataFormulirInput']);
        Route::get('/show/{id}', [AdminFormulirInputController::class, 'ShowDataFormulirInput']);
        Route::post('/create', [AdminFormulirInputController::class, 'CreateDataFormulirInput']);
        Route::post('/update/{id}', [AdminFormulirInputController::class, 'UpdateDataFormulirInput']);
        Route::post('/delete/{id}', [AdminFormulirInputController::class, 'DeleteDataFormulirInput']);
    });

    //Paket
    Route::prefix('paket')->group(function () {
        Route::get('/', [AdminPaketController::class, 'GetDataPaket']);
        Route::get('/show/{id}', [AdminPaketController::class, 'ShowDataPaket']);
        Route::post('/create', [AdminPaketController::class, 'CreateDataPaket']);
        Route::post('/update/{id}', [AdminPaketController::class, 'UpdateDataPaket']);
        Route::post('/delete/{id}', [AdminPaketController::class, 'DeleteDataPaket']);
    });

    //Program
    Route::prefix('program')->group(function () {
        Route::get('/', [AdminProgramController::class, 'GetDataProgram']);
        Route::get('/show/{id}', [AdminProgramController::class, 'ShowDataProgram']);
        Route::post('/create', [AdminProgramController::class, 'CreateDataProgram']);
        Route::post('/update/{id}', [AdminProgramController::class, 'UpdateDataProgram']);
        Route::post('/delete/{id}', [AdminProgramController::class, 'DeleteDataProgram']);
    });

    //Program Day
    Route::prefix('programday')->group(function () {
        Route::get('/', [AdminProgramDayController::class, 'GetDataProgramDay']);
        Route::get('/show/{id}', [AdminProgramDayController::class, 'ShowDataProgramDay']);
        Route::post('/create', [AdminProgramDayController::class, 'CreateDataProgramDay']);
        Route::post('/update/{id}', [AdminProgramDayController::class, 'UpdateDataProgramDay']);
        Route::post('/delete/{id}', [AdminProgramDayController::class, 'DeleteDataProgramDay']);
    });

    //Status Peserta Guru TU DLL
    Route::prefix('status')->group(function () {
        Route::post('/update/{uuid}', [StatusController::class, 'UpdateDataStatus']);
    });

    //User Active
    Route::prefix('status')->group(function () {
        Route::get('/user/active', [UserController::class, 'get_user_active']);
    });
});
