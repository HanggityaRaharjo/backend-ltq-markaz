<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\GuruTaskKelasController;
use App\Http\Controllers\SuperAdmin\CreateTableController;
use App\Http\Controllers\SuperAdmin\SuperAdminCabangLembagaController;
use App\Http\Controllers\UserController;
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

    //Management Peserta 
    require __DIR__ . '/peserta.php';

    // Management Guru
    require __DIR__ . '/guru.php';

    //Management Super Admin
    require __DIR__ . '/superadmin.php';

    //Management Admin Cabang
    require __DIR__ . '/admincabang.php';

    // Management Tata Usaha
    require __DIR__ . '/tatausaha.php';

    // Management Bendahara
    require __DIR__ . '/bendahara.php';

    // Management Panitia PSB
    require __DIR__ . '/panitia_psb.php';
});

Route::get('/user/get-all', [UserController::class, 'get_user']);

Route::get('/cabang/by-slug/{slug}', [SuperAdminCabangLembagaController::class, 'getCabangBySlug']);

Route::get('/get-kota', [SuperAdminCabangLembagaController::class, 'getAllKotaCabang']);

//Create Table
Route::prefix('createtable')->group(function () {
    Route::post('/', [CreateTableController::class, 'createTable']);
});

Route::prefix('task')->group(function () {
    Route::get('/all', [GuruTaskKelasController::class, 'getTaskAllKelas']);
    Route::get('/by-kelas/{kelas_id}', [GuruTaskKelasController::class, 'getTaskByKelas']);
    Route::post('/create', [GuruTaskKelasController::class, 'createTaskKelas']);
    Route::post('/update/{id}', [GuruTaskKelasController::class, 'updateTaskKelas']);
    Route::post('/delete/{id}', [GuruTaskKelasController::class, 'deleteTaskKelas']);
});

//Kirim Email
Route::prefix('kirim-email')->group(function () {
    Route::get('/user', [UserController::class, 'get_user']);
    Route::get('/', [UserController::class, 'kirimEmail']);
    Route::post('/tujuan', [UserController::class, 'kirimEmail']);
    Route::post('/broadcast', [UserController::class, 'kirimBroadcast']);
});
