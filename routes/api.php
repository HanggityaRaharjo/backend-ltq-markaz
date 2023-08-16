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
use App\Http\Controllers\Guru\GuruBiodataController;
use App\Http\Controllers\Guru\GuruBiodataGuruController;
use App\Http\Controllers\Guru\GuruCutiController;
use App\Http\Controllers\Guru\GuruInputNilaiSiswaController;
use App\Http\Controllers\Guru\GuruKelasController;
use App\Http\Controllers\Guru\GuruKurikulumController;
use App\Http\Controllers\Guru\GuruRaportSiswaController;
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
use App\Http\Controllers\Peserta\PesertaBiodataController;
use App\Http\Controllers\Peserta\PesertaBiodataPesertaController;
use App\Http\Controllers\Peserta\PesertaCutiController;
use App\Http\Controllers\Peserta\PesertaExamEssaiController;
use App\Http\Controllers\Peserta\PesertaExamPGController;
use App\Http\Controllers\Peserta\PesertaExamPraktikumController;
use App\Http\Controllers\Peserta\PesertaExamTypeController;
use App\Http\Controllers\Peserta\PesertaProgramPembayaranController;
use App\Http\Controllers\Peserta\PesertaRequestDayController;
use App\Http\Controllers\Peserta\PesertaUserCabangController as PesertaPesertaUserCabangController;
use App\Http\Controllers\Peserta\PesertaUserLevelController;
use App\Http\Controllers\Peserta\PesertaUserPaketCntroller;
use App\Http\Controllers\Peserta\PesertaUserProgramController;
use App\Http\Controllers\Peserta\PesertaVerifikasiPembayaranController;
use App\Http\Controllers\Peserta\ProgramController;
use App\Http\Controllers\Peserta\ProgramDayController;
use App\Http\Controllers\Peserta\ProgramHargaController;
use App\Http\Controllers\Peserta\ProgramPembayaranController;
use App\Http\Controllers\Peserta\TataUsahaBiodataController;
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
use App\Http\Controllers\TataUsaha\TataUsahaBarangController;
use App\Http\Controllers\TataUsaha\TataUsahaBiodataController as TataUsahaTataUsahaBiodataController;
use App\Http\Controllers\TataUsaha\TataUsahaCutiController;
use App\Http\Controllers\TataUsaha\TataUsahaDPPController;
use App\Http\Controllers\TataUsaha\TataUsahaKonsumenController;
use App\Http\Controllers\TataUsaha\TataUsahaPembayaranBarang;
use App\Http\Controllers\TataUsaha\TataUsahaSPPController;
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
        Route::get('/', [PesertaBiodataController::class, 'getbiodatapeserta']);
        Route::get('/show/{uuid}', [PesertaBiodataController::class, 'showbiodatapeserta']);
        Route::post('/create', [PesertaBiodataController::class, 'createbiodatapeserta']);
        Route::post('/update/{id}', [PesertaBiodataController::class, 'updatebiodatapeserta']);
        Route::post('/delete/{uuid}', [PesertaBiodataController::class, 'deletebiodatapeserta']);
        Route::post('/show/{uuid}', [PesertaBiodataController::class, 'showbiodatapeserta']);
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
        Route::prefix('user')->middleware('role:superadmi,admincabang,peserta')->group(function () {
            Route::get('/', [UserController::class, 'get_user']);
            Route::get('/show/{id}', [UserController::class, 'ShowDataProfileCabang']);
            Route::post('/create', [UserController::class, 'CreateDataProfileCabang']);
            Route::post('/{uuid}', [UserController::class, 'update_user']);
        });

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
        //User Active
        Route::prefix('status')->group(function () {
            Route::get('/user/active', [UserController::class, 'get_user_active']);
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
            Route::get('/', [PesertaUserPaketCntroller::class, 'GetDataUserPaket']);
            Route::get('/show/{id}', [PesertaUserPaketCntroller::class, 'ShowDataUserPaket']);
            Route::post('/create', [PesertaUserPaketCntroller::class, 'CreateDataUserPaket']);
            Route::post('/update/{id}', [PesertaUserPaketCntroller::class, 'UpdateDataUserPaket']);
            Route::post('/delete/{id}', [PesertaUserPaketCntroller::class, 'DeleteDataUserPaket']);
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
            Route::get('/', [PesertaUserProgramController::class, 'GetDataUserProgram']);
            Route::get('/show/{id}', [PesertaUserProgramController::class, 'ShowDataUserProgram']);
            Route::post('/create', [PesertaUserProgramController::class, 'CreateDataUserProgram']);
            Route::post('/update/{id}', [PesertaUserProgramController::class, 'UpdateDataUserProgram']);
            Route::post('/delete/{id}', [PesertaUserProgramController::class, 'DeleteDataUserProgram']);
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

        //User Cabang
        Route::prefix('user-cabang')->group(function () {
            Route::get('/', [PesertaUserCabangController::class, 'GetDataUserCabang']);
            Route::get('/show/{id}', [PesertaUserCabangController::class, 'ShowDataUserCabang']);
            Route::post('/create', [PesertaUserCabangController::class, 'CreateDataUserCabang']);
            Route::post('/update/{id}', [PesertaUserCabangController::class, 'UpdateDataUserCabang']);
            Route::post('/delete/{id}', [PesertaUserCabangController::class, 'DeleteGetDataUserCabang']);
        });
    });

    Route::prefix('user')->middleware('role:superadmi,admincabang,peserta')->group(function () {
        Route::post('/{uuid}', [UserController::class, 'update_user']);
    });
});

// Management Guru

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


// Management Tata Usaha

//Biodata Tata Usaha
Route::prefix('biodata-tatausaha')->group(function () {
    Route::get('/', [TataUsahaTataUsahaBiodataController::class, 'getbiodatatatausaha']);
    Route::get('/show/{uuid}', [TataUsahaTataUsahaBiodataController::class, 'showbiodatatatausaha']);
    Route::post('/create', [TataUsahaTataUsahaBiodataController::class, 'createbiodatatatausaha']);
    Route::post('/update/{id}', [TataUsahaTataUsahaBiodataController::class, 'updatebiodatatatausaha']);
    Route::post('/delete/{uuid}', [TataUsahaTataUsahaBiodataController::class, 'deletebiodatatatausaha']);
    Route::post('/show/{uuid}', [TataUsahaTataUsahaBiodataController::class, 'showbiodatatatausaha']);
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

//Pembayaran
Route::prefix('pembayaran-barang')->group(function () {
    Route::get('/', [TataUsahaPembayaranBarang::class, 'GetDataPembayranBarang']);
    Route::get('/show/{id}', [TataUsahaPembayaranBarang::class, 'ShowDataPembayranBarang']);
    Route::post('/create', [TataUsahaPembayaranBarang::class, 'CreateDataPembayranBarang']);
    Route::post('/update/{id}', [TataUsahaPembayaranBarang::class, 'UpdateDataPembayranBarang']);
    Route::post('/delete/{id}', [TataUsahaPembayaranBarang::class, 'DeleteDataPembayranBarang']);
});

//Create Table
Route::prefix('createtable')->group(function () {
    Route::post('/', [CreateTableController::class, 'createTable']);
});

Route::get('/test', function () {
    return response()->json(bcrypt('superadmin'));
});
