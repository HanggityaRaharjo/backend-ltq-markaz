<?php

use App\Http\Controllers\AdminCabang\AdminPembayaranController;
use App\Http\Controllers\AdminCabang\AdminProgramHargaController;
use App\Http\Controllers\AdminCabang\AdminRoleController;
use App\Http\Controllers\AdminCabang\FormulirController;
use App\Http\Controllers\AdminCabang\FormulirInputController;
use App\Http\Controllers\AdminCabang\ProfileCabangController;
use App\Http\Controllers\AdminCabang\StatusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\AbsensiGuruController;
use App\Http\Controllers\Guru\AbsensiPesertaController;
use App\Http\Controllers\Guru\GuruAbsensiGuruController;
use App\Http\Controllers\Guru\GuruAbsensiPesertaController;
use App\Http\Controllers\Guru\GuruBiodataGuruController;
use App\Http\Controllers\Guru\GuruKelasController;
use App\Http\Controllers\Guru\KelasController;
use App\Http\Controllers\Peserta\AdminProgramDayController;
use App\Http\Controllers\Peserta\BiodataPesertaController;
use App\Http\Controllers\Peserta\BuktiPembayaranController;
use App\Http\Controllers\Peserta\ExamEssaiController;
use App\Http\Controllers\Peserta\ExamPGController;
use App\Http\Controllers\Peserta\ExamPraktikumController;
use App\Http\Controllers\Peserta\ExamTypeController;
use App\Http\Controllers\Peserta\Paket;
use App\Http\Controllers\Peserta\PaketController;
use App\Http\Controllers\Peserta\PembayaranController;
use App\Http\Controllers\Peserta\PesertaBiodataPesertaController;
use App\Http\Controllers\Peserta\PesertaExamEssaiController;
use App\Http\Controllers\Peserta\PesertaExamPGController;
use App\Http\Controllers\Peserta\PesertaExamPraktikumController;
use App\Http\Controllers\Peserta\PesertaExamTypeController;
use App\Http\Controllers\Peserta\PesertaProgramPembayaranController;
use App\Http\Controllers\Peserta\PesertaUserLevelController;
use App\Http\Controllers\Peserta\PesertaUserProgramController;
use App\Http\Controllers\Peserta\PesertaVerifikasiPembayaranController;
use App\Http\Controllers\Peserta\ProgramController;
use App\Http\Controllers\Peserta\ProgramDayController;
use App\Http\Controllers\Peserta\ProgramHargaController;
use App\Http\Controllers\Peserta\ProgramPembayaranController;
use App\Http\Controllers\Peserta\UserLevelController;
use App\Http\Controllers\Peserta\UserPaketCntroller;
use App\Http\Controllers\Peserta\UserProgramController;
use App\Http\Controllers\Peserta\VerifikasiPembayaranController;
use App\Http\Controllers\ProgramHarga;
use App\Http\Controllers\ProgramHargaController as ControllersProgramHargaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperAdmin\BuatAkunController;
use App\Http\Controllers\SuperAdmin\CabangLembagaController;
use App\Http\Controllers\SuperAdmin\CreateTableController;
use App\Http\Controllers\SuperAdmin\PesertaUserCabangController;
use App\Http\Controllers\SuperAdmin\SuperAdminCabangLembagaController;
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
        Route::get('/', [SuperAdminCabangLembagaController::class, 'GetDataCabang']);
    });

    //User Cabang
    Route::prefix('user-cabang')->group(function () {
        Route::get('/', [PesertaUserCabangController::class, 'GetDataUserCabang']);
        Route::get('/show/{id}', [PesertaUserCabangController::class, 'ShowDataUserCabang']);
        Route::post('/create', [PesertaUserCabangController::class, 'CreateDataUserCabang']);
        Route::post('/update/{id}', [PesertaUserCabangController::class, 'UpdateDataUserCabang']);
        Route::post('/delete/{id}', [PesertaUserCabangController::class, 'DeleteGetDataUserCabang']);
    });

    //Biodata Peserta
    Route::prefix('biodata')->group(function () {
        Route::get('/', [PesertaBiodataPesertaController::class, 'getbiodatapeserta']);
        Route::get('/show/{uuid}', [PesertaBiodataPesertaController::class, 'showbiodatapeserta']);
        Route::post('/create', [PesertaBiodataPesertaController::class, 'createbiodatapeserta']);
        Route::post('/update/{id}', [PesertaBiodataPesertaController::class, 'updatebiodatapeserta']);
        Route::post('/delete/{uuid}', [PesertaBiodataPesertaController::class, 'deletebiodatapeserta']);
        Route::post('/show/{uuid}', [PesertaBiodataPesertaController::class, 'showbiodatapeserta']);
    });

    //Program
    Route::prefix('program')->group(function () {
        Route::get('/', [AdminProgramController::class, 'GetDataProgram']);
        Route::get('/show/{id}', [AdminProgramController::class, 'ShowDataProgram']);
        Route::post('/create', [AdminProgramController::class, 'CreateDataProgram']);
        Route::post('/update/{id}', [AdminProgramController::class, 'UpdateDataProgram']);
        Route::post('/delete/{id}', [AdminProgramController::class, 'DeleteDataProgram']);
    });

    //UserProgram
    Route::prefix('user-program')->group(function () {
        Route::get('/', [PesertaUserProgramController::class, 'GetDataUserProgram']);
        Route::get('/show/{uuid}', [PesertaUserProgramController::class, 'ShowDataUserProgram']);
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
        Route::get('/show/{uuid}', [PesertaExamTypeController::class, 'ShowDataExamType']);
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
        Route::get('/show/{uuid}', [PesertaVerifikasiPembayaranController::class, 'ShowDataVerifikasiPembayaran']);
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
            Route::get('/', [AdminProgramDayController::class, 'GetDataProgramDay']);
            Route::get('/show/{id}', [AdminProgramDayController::class, 'ShowDataProgramDay']);
            Route::post('/create', [AdminProgramDayController::class, 'CreateDataProgramDay']);
            Route::post('/update/{id}', [AdminProgramDayController::class, 'UpdateDataProgramDay']);
            Route::post('/delete/{id}', [AdminProgramDayController::class, 'DeleteDataProgramDay']);
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

    //Management Super Admin
    Route::prefix('superadmin')->middleware(['role:superadmin'])->group(function () {

        //Create Cabang
        Route::prefix('cabang')->group(function () {
            Route::get('/', [SuperAdminCabangLembagaController::class, 'GetDataCabang']);
            Route::get('/show/{id}', [SuperAdminCabangLembagaController::class, 'ShowDataCabang']);
            Route::post('/create', [SuperAdminCabangLembagaController::class, 'CreateDataCabang']);
            Route::post('/update/{id}', [SuperAdminCabangLembagaController::class, 'UpdateDataCabang']);
            Route::post('/delete/{id}', [SuperAdminCabangLembagaController::class, 'DeleteDataCabang']);
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
            Route::get('/', [AdminRoleController::class, 'GetDataRole']);
            Route::get('/show/{id}', [AdminRoleController::class, 'ShowDataRole']);
            Route::post('/create', [AdminRoleController::class, 'CreateDataRole']);
            Route::get('/show/{id}', [AdminRoleController::class, 'ShowDataRole']);
            Route::post('/update/{id}', [AdminRoleController::class, 'UpdateDataRole']);
            Route::post('/delete/{id}', [AdminRoleController::class, 'DeleteDataRole']);
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

//Biodata Guru
Route::prefix('biodata-guru')->group(function () {
    Route::get('/', [GuruBiodataGuruController::class, 'getbiodataguru']);
    Route::get('/show/{uuid}', [GuruBiodataGuruController::class, 'showbiodataguru']);
    Route::post('/create', [GuruBiodataGuruController::class, 'createbiodataguru']);
    Route::post('/update/{id}', [GuruBiodataGuruController::class, 'updatebiodataguru']);
    Route::post('/delete/{uuid}', [GuruBiodataGuruController::class, 'deletebiodataguru']);
    Route::post('/show/{uuid}', [GuruBiodataGuruController::class, 'showbiodataguru']);
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


//Create Table
Route::prefix('createtable')->group(function () {
    Route::post('/', [CreateTableController::class, 'createTable']);
});

Route::get('/test', function () {
    return response()->json(bcrypt('superadmin'));
});
