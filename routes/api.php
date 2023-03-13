<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use App\cutis;
use App\Http\Resources\AbsenResource;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//  Api Root
// api not auth
Route::prefix('non')->group(function () {
    Route::get('check','API\LoginControllre@check');
    Route::get('jabatan','API\ResponseContoller@resourceJabatan'); 
    Route::post('update-profile','API\ResponseContoller@updateProfile');
    Route::post('cuti-add','API\CutiController@store');
    Route::apiResource('absen','API\AbsensiController');
    // get absen by id
    Route::get('absen/{absen}/{date}/check','API\AbsensiController@check');
});
Route::post('login', 'API\LoginControllre@login');
Route::middleware('auth:api')->group(function () {
    Route::get('check','API\LoginControllre@check');
    Route::get('jabatan','API\ResponseContoller@resourceJabatan'); 
    Route::post('update-profile','API\ResponseContoller@updateProfile');
    Route::post('listcuti','API\ResponseContoller@listcuti');
    Route::get('list-absen/','API\ResponseContoller@listAbsen');
    Route::post('cuti-add','API\CutiController@store');
    Route::apiResource('absen','API\AbsensiController');
    Route::get('hapusdata','API\ResponseContoller@hapusdata');
    Route::get('cetakslipgaji','API\ResponseContoller@cetakslipgaji');
    Route::get('slipgaji','API\ResponseContoller@slipgaji');
    // get absen by id
    Route::get('absen/{absen}/{date}/check','API\AbsensiController@check');
    Route::get('listlembur','API\lembur@listdata');
    Route::post('addlembur','API\lembur@addlembur');

});
