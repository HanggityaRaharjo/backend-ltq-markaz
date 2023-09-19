<?php

use App\Http\Controllers\PanitiaPsb\PanitisPsbUserLevelController;
use Illuminate\Support\Facades\Route;
//UserLevel
Route::prefix('panitia-psb')->middleware('panitia_psb')->group(function () {

  //UserLevel
  Route::prefix('user-level')->group(function () {
    Route::get('/', [PanitisPsbUserLevelController::class, 'GetDataUserLevel']);
    Route::get('/show/{uuid}', [PanitisPsbUserLevelController::class, 'ShowDataUserLevel']);
    Route::post('/create', [PanitisPsbUserLevelController::class, 'CreateDataUserLevel']);
    Route::post('/update/{id}', [PanitisPsbUserLevelController::class, 'UpdateDataUserLevel']);
    Route::post('/delete/{id}', [PanitisPsbUserLevelController::class, 'DeleteDataUserLevel']);
  });
});
