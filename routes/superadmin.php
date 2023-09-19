<?php
//Super Admin
use App\Http\Controllers\AdminCabang\AdminRoleController;
use App\Http\Controllers\SuperAdmin\SuperAdminCabangLembagaController;
use App\Http\Controllers\UserController;

//Peserta
use App\Http\Controllers\AdminCabang\AdminPembayaranController;
use App\Http\Controllers\AdminCabang\AdminProgramController;
use App\Http\Controllers\AdminCabang\AdminProgramHargaController;
use App\Http\Controllers\Peserta\PesertaBiodataController;
use App\Http\Controllers\Peserta\PesertaExamEssaiController;
use App\Http\Controllers\Peserta\PesertaExamPGController;
use App\Http\Controllers\Peserta\PesertaExamPraktikumController;
use App\Http\Controllers\Peserta\PesertaExamTypeController;
use App\Http\Controllers\Peserta\PesertaProgramPembayaranController;
use App\Http\Controllers\Peserta\PesertaUserCabangController;
use App\Http\Controllers\Peserta\PesertaUserLevelController;
use App\Http\Controllers\Peserta\PesertaUserProgramController;
use App\Http\Controllers\Peserta\PesertaVerifikasiPembayaranController;
use Illuminate\Support\Facades\Route;

//Management Super Admin
Route::prefix('superadmin')->middleware('superadmin')->group(function () {

    //Create Cabang
    Route::prefix('cabang')->group(function () {
        Route::get('/', [SuperAdminCabangLembagaController::class, 'GetDataCabang']);
        // Route::get('/by-slug', [SuperAdminCabangLembagaController::class, 'getCabangBySlug']);
        Route::get('/get-kota', [SuperAdminCabangLembagaController::class, 'getAllKotaCabang']);
        Route::get('/show/{id}', [SuperAdminCabangLembagaController::class, 'ShowDataCabang']);
        Route::post('/create', [SuperAdminCabangLembagaController::class, 'CreateDataCabang']);
        Route::post('/update/{id}', [SuperAdminCabangLembagaController::class, 'UpdateDataCabang']);
        Route::post('/delete/{id}', [SuperAdminCabangLembagaController::class, 'DeleteDataCabang']);
    });

    //User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'get_user']);
        Route::get('/show/{id}', [UserController::class, 'ShowDataProfileCabang']);
        Route::post('/create', [UserController::class, 'CreateUserRole']);
        Route::post('/update/{id}', [UserController::class, 'update_user']);
        Route::get('/active', [UserController::class, 'get_user_active']);
    });

    Route::prefix('user/show/by-uuid')->group(function () {
        Route::get('/{uuid}', [UserController::class, 'ShowDataByUuidPeserta']);
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

    //Create Table
    Route::prefix('table')->group(function () {
        Route::get('/', [CreateTableController::class, 'GetDataUserCabang']);
        Route::get('/show/{id}', [CreateTableController::class, 'ShowDataUserCabang']);
        Route::post('/create', [CreateTableController::class, 'CreateDataUserCabang']);
        Route::get('/show/{id}', [CreateTableController::class, 'ShowDataUserCabang']);
        Route::post('/update/{id}', [CreateTableController::class, 'UpdateDataUserCabang']);
        Route::post('/delete/{id}', [CreateTableController::class, 'DeleteDataUserCabang']);
    });

    //Management Peserta 

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
    //Petunjuk Pengajar
    Route::prefix('petunjuk-pengajar')->group(function () {
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
        Route::get('/', [TataUsahaPembayaranBarang::class, 'GetDataPembayranBarang']);
        Route::get('/show/{id}', [TataUsahaPembayaranBarang::class, 'ShowDataPembayranBarang']);
        Route::post('/create', [TataUsahaPembayaranBarang::class, 'CreateDataPembayranBarang']);
        Route::post('/update/{id}', [TataUsahaPembayaranBarang::class, 'UpdateDataPembayranBarang']);
        Route::post('/delete/{id}', [TataUsahaPembayaranBarang::class, 'DeleteDataPembayranBarang']);
    });
});
