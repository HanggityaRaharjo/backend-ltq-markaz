<?php

use App\Http\Controllers\AdminCabang\FormulirController;
use App\Http\Controllers\AdminCabang\FormulirInputController;
use App\Http\Controllers\AdminCabang\ProfileCabangController;
use App\Http\Controllers\AdminCabang\StatusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peserta\BiodataPesertaController;
use App\Http\Controllers\Peserta\Paket;
use App\Http\Controllers\Peserta\PaketController;
use App\Http\Controllers\Peserta\ProgramController;
use App\Http\Controllers\Peserta\ProgramDayController;
use App\Http\Controllers\Peserta\UserLevelController;
use App\Http\Controllers\Peserta\UserPaketCntroller;
use App\Http\Controllers\Peserta\UserProgramController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperAdmin\BuatAkunController;
use App\Http\Controllers\SuperAdmin\CabangLembagaController;
use App\Http\Controllers\SuperAdmin\CreateTableController;
use App\Http\Controllers\UserController;
use App\Models\Peserta\UserPaket;
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

//Login JWT
Route::group(['middleware' => 'api'], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    //Management Super Admin
    Route::prefix('superadmin')->middleware(['role:superadmin'])->group(function () {

        //Create Cabang
        Route::prefix('cabang')->group(function () {
            Route::get('/', [CabangLembagaController::class, 'GetDataCabang']);
            Route::get('/show/{id}', [CabangLembagaController::class, 'ShowDataCabang']);
            Route::post('/create', [CabangLembagaController::class, 'CreateDataCabang']);
            Route::post('/update/{id}', [CabangLembagaController::class, 'UpdateDataCabang']);
            Route::post('/delete/{id}', [CabangLembagaController::class, 'DeleteDataCabang']);
        });

        //Create Akun
        Route::prefix('akun')->group(function () {
            Route::get('/', [BuatAkunController::class, 'GetDataAkun']);
            Route::get('/show/{id}', [BuatAkunController::class, 'ShowDataAkun']);
            Route::post('/create', [BuatAkunController::class, 'CreateDataAkun']);
            Route::post('/update/{id}', [BuatAkunController::class, 'UpdateDataAkun']);
            Route::post('/delete/{id}', [BuatAkunController::class, 'DeleteDataAkun']);
        });

        //Role
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'GetDataRole']);
            Route::post('/create', [RoleController::class, 'CreateDataRole']);
            Route::get('/show/{id}', [RoleController::class, 'ShowDataRole']);
            Route::post('/update/{id}', [RoleController::class, 'UpdateDataRole']);
            Route::post('/delete/{id}', [RoleController::class, 'DeleteDataRole']);
        });

        //Create Table
        Route::prefix('table')->group(function () {
            Route::get('/', [CreateTableController::class, 'GetDataUserCabang']);
            Route::post('/create', [CreateTableController::class, 'CreateDataUserCabang']);
            Route::get('/show/{id}', [CreateTableController::class, 'ShowDataUserCabang']);
            Route::post('/update/{id}', [CreateTableController::class, 'UpdateDataUserCabang']);
            Route::post('/delete/{id}', [CreateTableController::class, 'DeleteDataUserCabang']);
        });
    });

    //Management Admin Cabang
    Route::prefix('admincabang')->middleware('role:admincabang,superadmin')->group(function () {
        //Profile Cabang
        Route::prefix('Profile')->group(function () {
            Route::get('/', [ProfileCabangController::class, 'GetDataProfileCabang']);
            Route::post('/create', [ProfileCabangController::class, 'CreateDataProfileCabang']);
            Route::post('/update/{id}', [ProfileCabangController::class, 'UpdateDataProfileCabang']);
            Route::post('/delete/{id}', [ProfileCabangController::class, 'DeleteDataProfileCabang']);
        });

        //Status Peserta Guru TU DLL
        Route::prefix('status')->group(function () {
            Route::post('/update/{uuid}', [StatusController::class, 'UpdateDataStatus']);
        });

        //Role
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'GetDataRole']);
            Route::post('/create', [RoleController::class, 'CreateDataRole']);
            Route::get('/show/{id}', [RoleController::class, 'ShowDataRole']);
            Route::post('/update/{id}', [RoleController::class, 'UpdateDataRole']);
            Route::post('/delete/{id}', [RoleController::class, 'DeleteDataRole']);
        });

        //Formulir
        Route::prefix('formulir')->group(function () {
            Route::get('/', [FormulirController::class, 'GetDataFormulir']);
            Route::post('/create', [FormulirController::class, 'CreateDataFormulir']);
            Route::post('/update/{id}', [FormulirController::class, 'UpdateDataFormulir']);
            Route::post('/delete/{id}', [FormulirController::class, 'DeleteDataFormulir']);
        });

        //Formulir Input
        Route::prefix('formulirinput')->group(function () {
            Route::get('/', [FormulirInputController::class, 'GetDataFormulirInput']);
            Route::post('/create', [FormulirInputController::class, 'CreateDataFormulirInput']);
            Route::post('/update/{id}', [FormulirInputController::class, 'UpdateDataFormulirInput']);
            Route::post('/delete/{id}', [FormulirInputController::class, 'DeleteDataFormulirInput']);
        });
    });

    //Management Peserta
    Route::prefix('peserta')->middleware(['role:superadmin, peserta, admincabang'])->group(function () {
        //Biodata Peserta
        Route::prefix('biodata')->group(function () {
            Route::get('/', [BiodataPesertaController::class, 'getbiodatapeserta']);
            Route::get('/show/{uuid}', [BiodataPesertaController::class, 'showbiodatapeserta']);
            Route::post('/create', [BiodataPesertaController::class, 'createbiodatapeserta']);
            Route::post('/update/{id}', [BiodataPesertaController::class, 'updatebiodatapeserta']);
            Route::post('/delete/{uuid}', [BiodataPesertaController::class, 'deletebiodatapeserta']);
            Route::post('/show/{uuid}', [BiodataPesertaController::class, 'showbiodatapeserta']);
        });

        //UserLevel
        Route::prefix('userlevel')->group(function () {
            Route::get('/', [UserLevelController::class, 'GetDataUserLevel']);
            Route::post('/create', [UserLevelController::class, 'CreateDataUserLevel']);
            Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataUserLevel']);
            Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataUserLevel']);
        });

        //Paket
        Route::prefix('paket')->group(function () {
            Route::get('/', [PaketController::class, 'GetDataPaket']);
            Route::post('/create', [PaketController::class, 'CreateDataPaket']);
            Route::post('/update/{id}', [PaketController::class, 'UpdateDataPaket']);
            Route::post('/delete/{id}', [PaketController::class, 'DeleteDataPaket']);
        });

        //UserPaket
        Route::prefix('userpaket')->group(function () {
            Route::get('/', [UserPaketCntroller::class, 'GetDataUserPaket']);
            Route::post('/create', [UserPaketCntroller::class, 'CreateDataUserPaket']);
            Route::post('/update/{id}', [UserPaketCntroller::class, 'UpdateDataUserPaket']);
            Route::post('/delete/{id}', [UserPaketCntroller::class, 'DeleteDataUserPaket']);
        });

        //Program
        Route::prefix('program')->group(function () {
            Route::get('/', [ProgramController::class, 'GetDataProgram']);
            Route::post('/create', [ProgramController::class, 'CreateDataProgram']);
            Route::post('/update/{id}', [ProgramController::class, 'UpdateDataProgram']);
            Route::post('/delete/{id}', [ProgramController::class, 'DeleteDataProgram']);
        });

        //Program Day
        Route::prefix('programday')->group(function () {
            Route::get('/', [ProgramDayController::class, 'GetDataProgramDay']);
            Route::post('/create', [ProgramDayController::class, 'CreateDataProgramDay']);
            Route::post('/update/{id}', [ProgramDayController::class, 'UpdateDataProgramDay']);
            Route::post('/delete/{id}', [ProgramDayController::class, 'DeleteDataProgramDay']);
        });

        //UserProgram
        Route::prefix('userprogram')->group(function () {
            Route::get('/', [UserProgramController::class, 'GetDataUserProgram']);
            Route::post('/create', [UserProgramController::class, 'CreateDataUserProgram']);
            Route::post('/update/{id}', [UserProgramController::class, 'UpdateDataUserProgram']);
            Route::post('/delete/{id}', [UserProgramController::class, 'DeleteDataUserProgram']);
        });

        //RequestDay
        Route::prefix('requestday')->group(function () {
            Route::get('/', [UserProgramController::class, 'GetDataRequestDay']);
            Route::post('/create', [UserProgramController::class, 'CreateDataRequestDay']);
            Route::post('/update/{id}', [UserProgramController::class, 'UpdateDataRequestDay']);
            Route::post('/delete/{id}', [UserProgramController::class, 'DeleteDataRequestDay']);
        });

        //Cuti
        Route::prefix('cuti')->group(function () {
            Route::get('/', [UserProgramController::class, 'GetDataCuti']);
            Route::post('/create', [UserProgramController::class, 'CreateDataCuti']);
            Route::post('/update/{id}', [UserProgramController::class, 'UpdateDataCuti']);
            Route::post('/delete/{id}', [UserProgramController::class, 'DeleteGetDataCuti']);
        });
    });

    Route::prefix('user')->middleware('role:superadmi,admincabang,peserta')->group(function () {
        Route::post('/{uuid}', [UserController::class, 'update_user']);
    });
});


//Exam Type
Route::prefix('examtype')->group(function () {
    Route::get('/', [UserLevelController::class, 'GetDataUserLevel']);
    Route::post('/create', [UserLevelController::class, 'CreateDataUserLevel']);
    Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataUserLevel']);
    Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataUserLevel']);
});

//Exam PG
Route::prefix('examtype')->group(function () {
    Route::get('/', [UserLevelController::class, 'GetDataExamPG']);
    Route::post('/create', [UserLevelController::class, 'CreateDataExamPG']);
    Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataExamPG']);
    Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataExamPG']);
});

//Exam Essai
Route::prefix('examtype')->group(function () {
    Route::get('/', [UserLevelController::class, 'GetDataExamEssai']);
    Route::post('/create', [UserLevelController::class, 'CreateDataExamEssai']);
    Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataExamEssai']);
    Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataExamEssai']);
});

//Exam Praktikum
Route::prefix('examtype')->group(function () {
    Route::get('/', [UserLevelController::class, 'GetDataExamPraktikum']);
    Route::post('/create', [UserLevelController::class, 'CreateDataExamPraktikum']);
    Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataExamPraktikum']);
    Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataExamPraktikum']);
});

//Create Table
Route::prefix('createtable')->group(function () {
    Route::post('/', [CreateTableController::class, 'createTable']);
});

Route::get('/test', function () {
    return response()->json(bcrypt('superadmin'));
});
