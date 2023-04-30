<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/backend/home');
});
Auth::routes();
// Route::middleware(['auth'])->group(function () {
Route::prefix('backend')->group(function () {
    Route::get('/home', 'backend\HomeController@index')->name('home');
    Route::get('/detail-pegawai-terlambat','backend\HomeController@detailPegawaiTerlambat');

    Route::get('/edit-profile', 'backend\HomeController@editprofile')->name('editprofile');
    Route::post('/edit-profile/{id}', 'backend\HomeController@aksieditprofile');

    Route::resource('/roles','backend\rolesController');
    Route::get('/data-roles','backend\rolesController@listdata');
    
    Route::get('/data-admin','backend\AdminController@listdata');
    Route::resource('/admin','backend\AdminController');
    Route::get('/web-setting', 'backend\HomeController@websetting');
    Route::post('/web-setting', 'backend\HomeController@updatewebsetting');

    Route::resource('/pegawai', 'backend\PegawaiController');
    Route::get('/data-pegawai','backend\PegawaiController@listdata');
    Route::get('/data-pegawai-ajax','backend\PegawaiController@listdataajax');

    Route::resource('/divisi', 'backend\DivisiController');
    Route::get('/data-divisi','backend\DivisiController@listdata');
    Route::get('/data-divisi-ajax','backend\DivisiController@listdataajax');

    Route::resource('/jabatan', 'backend\JabatanController');
    Route::get('/data-jabatan','backend\JabatanController@listdata');
    Route::get('/data-jabatan-ajax','backend\JabatanController@listdataajax');

    Route::resource('/shift', 'backend\ShiftController');
    Route::get('/data-shift','backend\ShiftController@listdata');
    Route::get('/data-shift-ajax','backend\ShiftController@listdataajax');

    // Absensi Root
    Route::resource('/absensi', 'backend\AbsensiController');
    Route::resource('/cuti', 'backend\CutiController');
    Route::get('/data-cuti','backend\CutiController@listdata');
    Route::get('cuti/{id}/tolak', 'backend\CutiController@tolak');
    Route::get('/data-cuti-pendding','backend\CutiController@listdataP');
    Route::get('/permohonan-cuti', 'backend\CutiController@phcuti');
    Route::get('/data-absen', 'backend\AbsensiController@DataAbsen');
    Route::get('/cetakslipgaji','exportController@cetakslipgaji');

    // Client Root
    Route::resource('/client', 'backend\ClientController');
    Route::get('/data-client', 'backend\ClientController@listdata');
    
    //jadwal Shift
    Route::resource('jadwal','backend\JadwalshiftCotroller');
    Route::get('add-jadwal/{id}/{date}/{type}','backend\JadwalshiftCotroller@AddJadwal');
    Route::get('list-add-jadwal','backend\JadwalshiftCotroller@listdata');
    Route::get('list-jadwal','backend\JadwalshiftCotroller@Listjadwal');
    Route::get('slug-id/{month}/{year}/{type}/{time}','backend\JadwalshiftCotroller@slugid');
    Route::get('detail-jadwal/{type}/{tanggal}','backend\JadwalshiftCotroller@detailJadwal');

    
    //lembur
    Route::resource('lembur','backend\lemburController');
    Route::get('datalist-lembur','backend\lemburController@listdata');
    Route::get('datalist-lemburP','backend\lemburController@listdataP');
    Route::get('permohonan-lembur','backend\lemburController@permohonan');
    Route::get('lembur-action/{id}/{status}','backend\lemburController@actionpermohonan');

    
    // gaji
    Route::get('cetakslipgaji','backend\umkController@cetakslipgaji');
    Route::get('datalist-umk','backend\umkController@listdata');
    Route::get('datalist-bpjs','backend\bpjskController@listdata');
    Route::get('datalist-tlb','backend\Tlb@listdata');
    Route::get('datalist-tk','backend\Tk@listdata');
    Route::get('datalist-lg','backend\laporangaji@listdata');
    Route::get('datalist-lg-month/{month}','backend\laporangaji@listdatabymonth');
    Route::get('laporangajiAjax','backend\laporangaji@indexAjax');
    Route::get('perhitunganGajiAjax','backend\laporangaji@perhitunganGaji');


    Route::resource('bpjs','backend\bpjskController');
    Route::resource('umk','backend\umkController');
    Route::resource('tunjangankeahlian', 'backend\Tk');
    Route::resource('tunjanganlamaberkerja', 'backend\Tlb');
    Route::resource('laporangaji','backend\laporangaji');

    // debug 
    Route::get('gajicreate','debug\createdgaji@create');

});    
// });

