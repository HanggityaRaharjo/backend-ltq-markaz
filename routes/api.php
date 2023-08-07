<?php

use App\Http\Controllers\AdminCabang\FormulirController;
use App\Http\Controllers\AdminCabang\FormulirInputController;
use App\Http\Controllers\AdminCabang\ProfileCabangController;
use App\Http\Controllers\AdminCabang\StatusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\AbsensiGuruController;
use App\Http\Controllers\Guru\AbsensiPesertaController;
use App\Http\Controllers\Guru\KelasController;
use App\Http\Controllers\Peserta\BiodataPesertaController;
use App\Http\Controllers\Peserta\BuktiPembayaranController;
use App\Http\Controllers\Peserta\ExamEssaiController;
use App\Http\Controllers\Peserta\ExamPGController;
use App\Http\Controllers\Peserta\ExamPraktikumController;
use App\Http\Controllers\Peserta\ExamTypeController;
use App\Http\Controllers\Peserta\Paket;
use App\Http\Controllers\Peserta\PaketController;
use App\Http\Controllers\Peserta\PembayaranController;
use App\Http\Controllers\Peserta\ProgramController;
use App\Http\Controllers\Peserta\ProgramDayController;
use App\Http\Controllers\Peserta\ProgramHargaController;
use App\Http\Controllers\Peserta\ProgramPembayaranController;
use App\Http\Controllers\Peserta\UserLevelController;
use App\Http\Controllers\Peserta\UserPaketCntroller;
use App\Http\Controllers\Peserta\UserProgramController;
use App\Http\Controllers\ProgramHarga;
use App\Http\Controllers\ProgramHargaController as ControllersProgramHargaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperAdmin\BuatAkunController;
use App\Http\Controllers\SuperAdmin\CabangLembagaController;
use App\Http\Controllers\SuperAdmin\CreateTableController;
use App\Http\Controllers\SuperAdmin\UserCabangController;
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

    Route::prefix('cabang')->group(function () {
        Route::get('/', [CabangLembagaController::class, 'GetDataCabang']);
    });

    //User Cabang
    Route::prefix('user-cabang')->group(function () {
        Route::get('/', [UserCabangController::class, 'GetDataUserCabang']);
        Route::get('/show/{id}', [UserCabangController::class, 'ShowDataUserCabang']);
        Route::post('/create', [UserCabangController::class, 'CreateDataUserCabang']);
        Route::post('/update/{id}', [UserCabangController::class, 'UpdateDataUserCabang']);
        Route::post('/delete/{id}', [UserCabangController::class, 'DeleteGetDataUserCabang']);
    });

    //Biodata Peserta
    Route::prefix('biodata')->group(function () {
        Route::get('/', [BiodataPesertaController::class, 'getbiodatapeserta']);
        Route::get('/show/{uuid}', [BiodataPesertaController::class, 'showbiodatapeserta']);
        Route::post('/create', [BiodataPesertaController::class, 'createbiodatapeserta']);
        Route::post('/update/{id}', [BiodataPesertaController::class, 'updatebiodatapeserta']);
        Route::post('/delete/{uuid}', [BiodataPesertaController::class, 'deletebiodatapeserta']);
        Route::post('/show/{uuid}', [BiodataPesertaController::class, 'showbiodatapeserta']);
    });

    //Program
    Route::prefix('program')->group(function () {
        Route::get('/', [ProgramController::class, 'GetDataProgram']);
        Route::get('/show/{id}', [ProgramController::class, 'ShowDataProgram']);
        Route::post('/create', [ProgramController::class, 'CreateDataProgram']);
        Route::post('/update/{id}', [ProgramController::class, 'UpdateDataProgram']);
        Route::post('/delete/{id}', [ProgramController::class, 'DeleteDataProgram']);
    });

    //UserProgram
    Route::prefix('user-program')->group(function () {
        Route::get('/', [UserProgramController::class, 'GetDataUserProgram']);
        Route::get('/show/{uuid}', [UserProgramController::class, 'ShowDataUserProgram']);
        Route::post('/create', [UserProgramController::class, 'CreateDataUserProgram']);
        Route::post('/update/{id}', [UserProgramController::class, 'UpdateDataUserProgram']);
        Route::post('/delete/{id}', [UserProgramController::class, 'DeleteDataUserProgram']);
    });

    //Program Pembayaran
    Route::prefix('program-pembayaran')->group(function () {
        Route::get('/', [ProgramPembayaranController::class, 'GetDataProgramPembayaran']);
        Route::get('/show/{id}', [ProgramPembayaranController::class, 'ShowDataProgramPembayaran']);
        Route::post('/create', [ProgramPembayaranController::class, 'CreateDataProgramPembayaran']);
        Route::post('/update/{id}', [ProgramPembayaranController::class, 'UpdateDataProgramPembayaran']);
        Route::post('/delete/{id}', [ProgramPembayaranController::class, 'DeleteGetDataProgramPembayaran']);
    });

    //Program harga
    Route::prefix('program-harga')->group(function () {
        Route::get('/', [ControllersProgramHargaController::class, 'GetDataProgramHarga']);
        Route::get('/show/{id}', [ControllersProgramHargaController::class, 'ShowDataProgramHarga']);
        Route::post('/create', [ControllersProgramHargaController::class, 'CreateDataProgramHarga']);
        Route::post('/update/{id}', [ControllersProgramHargaController::class, 'UpdateDataProgramHarga']);
        Route::post('/delete/{id}', [ControllersProgramHargaController::class, 'DeleteGetDataProgramHarga']);
    });
    //Pembayaran
    Route::prefix('pembayaran')->group(function () {
        Route::get('/', [PembayaranController::class, 'GetDataPembayaran']);
        Route::get('/show/{id}', [PembayaranController::class, 'ShowDataPembayaran']);
        Route::post('/create', [PembayaranController::class, 'CreateDataPembayaran']);
        Route::post('/code/{id}', [PembayaranController::class, 'GenerateCode']);
        Route::post('/update/{id}', [PembayaranController::class, 'UpdateDataPembayaran']);
        Route::post('/delete/{id}', [PembayaranController::class, 'DeleteGetDataPembayaran']);
    });

    //Exam Type
    Route::prefix('exam-type')->group(function () {
        Route::get('/', [ExamTypeController::class, 'GetDataExamType']);
        Route::get('/show/{id}', [ExamTypeController::class, 'ShowDataExamType']);
        Route::post('/create', [ExamTypeController::class, 'CreateDataExamType']);
        Route::post('/update/{id}', [ExamTypeController::class, 'UpdateDataExamType']);
        Route::post('/delete/{id}', [ExamTypeController::class, 'DeleteDataExamType']);
    });

    //Exam PG
    Route::prefix('exampg')->group(function () {
        Route::get('/', [ExamPGController::class, 'GetDataExamPG']);
        Route::get('/show/{id}', [ExamPGController::class, 'ShowDataExamPG']);
        Route::post('/create', [ExamPGController::class, 'CreateDataExamPG']);
        Route::post('/update/{id}', [ExamPGController::class, 'UpdateDataExamPG']);
        Route::post('/delete/{id}', [ExamPGController::class, 'DeleteDataExamPG']);
    });

    //UserLevel
    Route::prefix('user-level')->group(function () {
        Route::get('/', [UserLevelController::class, 'GetDataUserLevel']);
        Route::get('/show/{id}', [UserLevelController::class, 'ShowDataUserLevel']);
        Route::post('/create', [UserLevelController::class, 'CreateDataUserLevel']);
        Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataUserLevel']);
        Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataUserLevel']);
    });

    //Bukti Pembayaran
    Route::prefix('bukti-pembayaran')->group(function () {
        Route::get('/', [BuktiPembayaranController::class, 'GetDataBuktiPembayaran']);
        Route::get('/show/{id}', [BuktiPembayaranController::class, 'ShowDataBuktiPembayaran']);
        Route::post('/create', [BuktiPembayaranController::class, 'CreateDataBuktiPembayaran']);
        Route::post('/update/{id}', [BuktiPembayaranController::class, 'UpdateDataBuktiPembayaran']);
        Route::post('/delete/{id}', [BuktiPembayaranController::class, 'DeleteGetDataBuktiPembayaran']);
    });


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
            Route::get('/show/{id}', [RoleController::class, 'ShowDataRole']);
            Route::post('/create', [RoleController::class, 'CreateDataRole']);
            Route::get('/show/{id}', [RoleController::class, 'ShowDataRole']);
            Route::post('/update/{id}', [RoleController::class, 'UpdateDataRole']);
            Route::post('/delete/{id}', [RoleController::class, 'DeleteDataRole']);
        });

        //Create Table
        Route::prefix('table')->group(function () {
            Route::get('/', [CreateTableController::class, 'GetDataUserCabang']);
            Route::get('/show/{id}', [CreateTableController::class, 'ShowDataUserCabang']);
            Route::post('/create', [CreateTableController::class, 'CreateDataUserCabang']);
            Route::get('/show/{id}', [CreateTableController::class, 'ShowDataUserCabang']);
            Route::post('/update/{id}', [CreateTableController::class, 'UpdateDataUserCabang']);
            Route::post('/delete/{id}', [CreateTableController::class, 'DeleteDataUserCabang']);
        });

        //Exam PG
        Route::prefix('exampg')->group(function () {
            Route::get('/', [ExamPGController::class, 'GetDataExamPG']);
            Route::get('/show/{id}', [ExamPGController::class, 'ShowDataExamPG']);
            Route::post('/create', [ExamPGController::class, 'CreateDataExamPG']);
            Route::post('/update/{id}', [ExamPGController::class, 'UpdateDataExamPG']);
            Route::post('/delete/{id}', [ExamPGController::class, 'DeleteDataExamPG']);
        });

        //Exam Essai
        Route::prefix('examessai')->group(function () {
            Route::get('/', [ExamEssaiController::class, 'GetDataExamEssai']);
            Route::get('/show/{id}', [ExamEssaiController::class, 'ShowDataExamEssai']);
            Route::post('/create', [ExamEssaiController::class, 'CreateDataExamEssai']);
            Route::post('/update/{id}', [ExamEssaiController::class, 'UpdateDataExamEssai']);
            Route::post('/delete/{id}', [ExamEssaiController::class, 'DeleteDataExamEssai']);
        });

        //Exam Praktikum
        Route::prefix('examprak')->group(function () {
            Route::get('/', [ExamPraktikumController::class, 'GetDataExamPraktikum']);
            Route::get('/show/{id}', [ExamPraktikumController::class, 'ShowDataExamPraktikum']);
            Route::post('/create', [ExamPraktikumController::class, 'CreateDataExamPraktikum']);
            Route::post('/update/{id}', [ExamPraktikumController::class, 'UpdateDataExamPraktikum']);
            Route::post('/delete/{id}', [ExamPraktikumController::class, 'DeleteDataExamPraktikum']);
        });

        //UserLevel
        Route::prefix('userlevel')->group(function () {
            Route::get('/', [UserLevelController::class, 'GetDataUserLevel']);
            Route::get('/show/{id}', [UserLevelController::class, 'ShowDataUserLevel']);
            Route::post('/create', [UserLevelController::class, 'CreateDataUserLevel']);
            Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataUserLevel']);
            Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataUserLevel']);
        });
    });

    //Management Admin Cabang
    Route::prefix('admincabang')->middleware('role:admincabang,superadmin')->group(function () {
        //Profile Cabang
        Route::prefix('Profile')->group(function () {
            Route::get('/', [ProfileCabangController::class, 'GetDataProfileCabang']);
            Route::get('/show/{id}', [ProfileCabangController::class, 'ShowDataProfileCabang']);
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
            Route::get('/show/{id}', [RoleController::class, 'ShowDataRole']);
            Route::post('/create', [RoleController::class, 'CreateDataRole']);
            Route::get('/show/{id}', [RoleController::class, 'ShowDataRole']);
            Route::post('/update/{id}', [RoleController::class, 'UpdateDataRole']);
            Route::post('/delete/{id}', [RoleController::class, 'DeleteDataRole']);
        });

        //Formulir
        Route::prefix('formulir')->group(function () {
            Route::get('/', [FormulirController::class, 'GetDataFormulir']);
            Route::get('/show/{id}', [FormulirController::class, 'ShowDataFormulir']);
            Route::post('/create', [FormulirController::class, 'CreateDataFormulir']);
            Route::post('/update/{id}', [FormulirController::class, 'UpdateDataFormulir']);
            Route::post('/delete/{id}', [FormulirController::class, 'DeleteDataFormulir']);
        });

        //Formulir Input
        Route::prefix('formulirinput')->group(function () {
            Route::get('/', [FormulirInputController::class, 'GetDataFormulirInput']);
            Route::get('/show/{id}', [FormulirInputController::class, 'ShowDataFormulirInput']);
            Route::post('/create', [FormulirInputController::class, 'CreateDataFormulirInput']);
            Route::post('/update/{id}', [FormulirInputController::class, 'UpdateDataFormulirInput']);
            Route::post('/delete/{id}', [FormulirInputController::class, 'DeleteDataFormulirInput']);
        });

        //Paket
        Route::prefix('paket')->group(function () {
            Route::get('/', [PaketController::class, 'GetDataPaket']);
            Route::get('/show/{id}', [PaketController::class, 'ShowDataPaket']);
            Route::post('/create', [PaketController::class, 'CreateDataPaket']);
            Route::post('/update/{id}', [PaketController::class, 'UpdateDataPaket']);
            Route::post('/delete/{id}', [PaketController::class, 'DeleteDataPaket']);
        });

        //Program
        Route::prefix('program')->group(function () {
            Route::get('/', [ProgramController::class, 'GetDataProgram']);
            Route::get('/show/{id}', [ProgramController::class, 'ShowDataProgram']);
            Route::post('/create', [ProgramController::class, 'CreateDataProgram']);
            Route::post('/update/{id}', [ProgramController::class, 'UpdateDataProgram']);
            Route::post('/delete/{id}', [ProgramController::class, 'DeleteDataProgram']);
        });
        //Program Day
        Route::prefix('programday')->group(function () {
            Route::get('/', [ProgramDayController::class, 'GetDataProgramDay']);
            Route::get('/show/{id}', [ProgramDayController::class, 'ShowDataProgramDay']);
            Route::post('/create', [ProgramDayController::class, 'CreateDataProgramDay']);
            Route::post('/update/{id}', [ProgramDayController::class, 'UpdateDataProgramDay']);
            Route::post('/delete/{id}', [ProgramDayController::class, 'DeleteDataProgramDay']);
        });

        //UserLevel
        Route::prefix('userlevel')->group(function () {
            Route::get('/', [UserLevelController::class, 'GetDataUserLevel']);
            Route::get('/show/{id}', [UserLevelController::class, 'ShowDataUserLevel']);
            Route::post('/create', [UserLevelController::class, 'CreateDataUserLevel']);
            Route::post('/update/{id}', [UserLevelController::class, 'UpdateDataUserLevel']);
            Route::post('/delete/{id}', [UserLevelController::class, 'DeleteDataUserLevel']);
        });
    });

    //Management Peserta
    Route::prefix('peserta')->group(function () {
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
            Route::get('/show/{id}', [UserLevelController::class, 'ShowDataUserLevel']);
            Route::post('/create', [UserLevelController::class, 'CreateDataUserLevel']);
        });

        //UserPaket
        Route::prefix('userpaket')->group(function () {
            Route::get('/', [UserPaketCntroller::class, 'GetDataUserPaket']);
            Route::get('/show/{id}', [UserPaketCntroller::class, 'ShowDataUserPaket']);
            Route::post('/create', [UserPaketCntroller::class, 'CreateDataUserPaket']);
            Route::post('/update/{id}', [UserPaketCntroller::class, 'UpdateDataUserPaket']);
            Route::post('/delete/{id}', [UserPaketCntroller::class, 'DeleteDataUserPaket']);
        });

        //Program Day
        Route::prefix('programday')->group(function () {
            Route::get('/', [ProgramDayController::class, 'GetDataProgramDay']);
            Route::get('/show/{id}', [ProgramDayController::class, 'ShowDataProgramDay']);
            Route::post('/create', [ProgramDayController::class, 'CreateDataProgramDay']);
            Route::post('/update/{id}', [ProgramDayController::class, 'UpdateDataProgramDay']);
            Route::post('/delete/{id}', [ProgramDayController::class, 'DeleteDataProgramDay']);
        });

        //UserProgram
        Route::prefix('userprogram')->group(function () {
            Route::get('/', [UserProgramController::class, 'GetDataUserProgram']);
            Route::get('/show/{id}', [UserProgramController::class, 'ShowDataUserProgram']);
            Route::post('/create', [UserProgramController::class, 'CreateDataUserProgram']);
            Route::post('/update/{id}', [UserProgramController::class, 'UpdateDataUserProgram']);
            Route::post('/delete/{id}', [UserProgramController::class, 'DeleteDataUserProgram']);
        });

        //RequestDay
        Route::prefix('requestday')->group(function () {
            Route::get('/', [UserProgramController::class, 'GetDataRequestDay']);
            Route::get('/show/{id}', [UserProgramController::class, 'ShowDataRequestDay']);
            Route::post('/create', [UserProgramController::class, 'CreateDataRequestDay']);
            Route::post('/update/{id}', [UserProgramController::class, 'UpdateDataRequestDay']);
            Route::post('/delete/{id}', [UserProgramController::class, 'DeleteDataRequestDay']);
        });

        //Cuti
        Route::prefix('cuti')->group(function () {
            Route::get('/', [UserProgramController::class, 'GetDataCuti']);
            Route::get('/show/{id}', [UserProgramController::class, 'ShowDataCuti']);
            Route::post('/create', [UserProgramController::class, 'CreateDataCuti']);
            Route::post('/update/{id}', [UserProgramController::class, 'UpdateDataCuti']);
            Route::post('/delete/{id}', [UserProgramController::class, 'DeleteGetDataCuti']);
        });

        //Bukti Pembayaran
        Route::prefix('buktipembayaran')->group(function () {
            Route::get('/', [BuktiPembayaranController::class, 'GetDataBuktiPembayaran']);
            Route::get('/show/{id}', [BuktiPembayaranController::class, 'ShowDataBuktiPembayaran']);
            Route::post('/create', [BuktiPembayaranController::class, 'CreateDataBuktiPembayaran']);
            Route::post('/update/{id}', [BuktiPembayaranController::class, 'UpdateDataBuktiPembayaran']);
            Route::post('/delete/{id}', [BuktiPembayaranController::class, 'DeleteGetDataBuktiPembayaran']);
        });

        //User Cabang
        Route::prefix('user-cabang')->group(function () {
            Route::get('/', [UserCabangController::class, 'GetDataUserCabang']);
            Route::get('/show/{id}', [UserCabangController::class, 'ShowDataUserCabang']);
            Route::post('/create', [UserCabangController::class, 'CreateDataUserCabang']);
            Route::post('/update/{id}', [UserCabangController::class, 'UpdateDataUserCabang']);
            Route::post('/delete/{id}', [UserCabangController::class, 'DeleteGetDataUserCabang']);
        });
    });

    Route::prefix('user')->middleware('role:superadmi,admincabang,peserta')->group(function () {
        Route::post('/{uuid}', [UserController::class, 'update_user']);
    });
});


// Management Guru

//Kelas
Route::prefix('kelas')->group(function () {
    Route::get('/', [KelasController::class, 'GetDataKelas']);
    Route::get('/show/{id}', [KelasController::class, 'ShowDataKelas']);
    Route::post('/create', [KelasController::class, 'CreateDataKelas']);
    Route::post('/update/{id}', [KelasController::class, 'UpdateDataKelas']);
    Route::post('/delete/{id}', [KelasController::class, 'DeleteDataKelas']);
});

//Absensi Peserta
Route::prefix('absensi-peserta')->group(function () {
    Route::get('/', [AbsensiPesertaController::class, 'GetDataAbsensiPeserta']);
    Route::get('/show/{id}', [AbsensiPesertaController::class, 'ShowDataAbsensiPeserta']);
    Route::post('/create', [AbsensiPesertaController::class, 'CreateDataAbsensiPeserta']);
    Route::post('/update/{id}', [AbsensiPesertaController::class, 'UpdateDataAbsensiPeserta']);
    Route::post('/delete/{id}', [AbsensiPesertaController::class, 'DeleteDataAbsensiPeserta']);
});


//Absensi Guru
Route::prefix('absensi-guru')->group(function () {
    Route::get('/', [AbsensiGuruController::class, 'GetDataAbsensiGuru']);
    Route::get('/show/{id}', [AbsensiGuruController::class, 'ShowDataAbsensiGuru']);
    Route::post('/create', [AbsensiGuruController::class, 'CreateDataAbsensiGuru']);
    Route::post('/update/{id}', [AbsensiGuruController::class, 'UpdateDataAbsensiGuru']);
    Route::post('/delete/{id}', [AbsensiGuruController::class, 'DeleteDataAbsensiGuru']);
});


//Create Table
Route::prefix('createtable')->group(function () {
    Route::post('/', [CreateTableController::class, 'createTable']);
});

Route::get('/test', function () {
    return response()->json(bcrypt('superadmin'));
});
