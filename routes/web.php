<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('vendor');
Route::resource('home','HomeController')->middleware('vendor');

// Route::get('home/{id}/show/', 'HomeController@showing')->name('home.showing');
// Route::post('/','HomeController@komentar')->name('home.komentar');

Route::get('login-user', function () {
    return view('login/index');
});

Route::get('daftar-login', function () {
    return view('login/daftar');
});
Route::post('login-user','Auth\LoginController@login')->name('loginpost');
Route::post('daftar-login','Auth\RegisterController@showRegistrationForm')->name('register-create');




// HOMEE
Route::get('/', 'IndexController@index')->name('index');
// ABOUT
Route::get('about', 'IndexController@about')->name('about');

// INI MIDDLEWARE ADMIN
// DASHBOARD ADMIN
Route::resource('admin/dashboard','AdminController')->middleware('admin');
Route::get('admin/dashboard', 'AdminController@index')->name('admin/dashboard')->middleware('admin');
// PENGADUAN - TANGGAPAN
Route::resource('admin/pengaduan','TanggapanController')->middleware('admin');
Route::post('admin/pengaduan/{id}/show/', 'TanggapanController@updateyeh')->name('tanggapan-update')->middleware('admin');
Route::get('admin/pengaduan/{id}/show/', 'TanggapanController@showing')->name('tanggapan.showing')->middleware('admin');
Route::get('admin/pengaduan/cari','TanggapanController@cari')->name('cari-pengaduan')->middleware('admin');
// KOMENTAR
Route::resource('admin/komentar','KomentarController')->middleware('admin');
// Purchase Order
Route::resource('admin/po', 'PoController')->middleware('admin');
Route::get('admin/po/{id}/show/', 'PoController@showing')->name('pengumuman.showing')->middleware('admin');
// Invoice 
Route::get('admin/invoice', 'InvoiceController@showing')->middleware('admin');
//Purcahse order disputed
Route::get('admin/disputed', 'PoController@disputed')->middleware('admin');
// PENGUMUMAN
Route::resource('admin/pengumuman', 'PengumumanController')->middleware('admin');
Route::get('admin/pengumuman/{id}/show/', 'PengumumanController@showing')->name('pengumuman.showing')->middleware('admin');

// USER
Route::resource('admin/user', 'UserController')->middleware('admin');
Route::get('admin/user/{id}/profile', 'UserController@showing')->name('user.showing')->middleware('admin');
Route::get('admin/user/create', 'UserController@create')->name('tambah-user')->middleware('admin');
Route::post('admin/user/create', 'UserController@store')->name('create-user')->middleware('admin');

// Accounting
Route::resource('admin/accounting', 'AccountingController')->middleware('admin');
Route::get('admin/accounting/{id}/show', 'AccountingController@showing')->name('accounting.showing')->middleware('admin');
Route::get('admin/accounting/{id}/ubah-accounting', 'AccountingController@profile')->name('accounting.edit')->middleware('admin');
Route::post('admin/accounting/{id}/ubah-accounting', 'AccountingController@updatedong')->name('accounting-update')->middleware('admin');

// Warehouse
Route::resource('admin/warehouse', 'WarehouseController')->middleware('admin');
Route::get('admin/warehouse/{id}/show', 'WarehouseController@showing')->name('warehouse.showing')->middleware('admin');
Route::get('admin/warehouse/{id}/ubah-warehouse', 'WarehouseController@profile')->name('warehouse.edit')->middleware('admin');
Route::post('admin/warehouse/{id}/ubah-warehouse', 'WarehouseController@updatedong')->name('warehouse-update')->middleware('admin');

// Procumerent
Route::resource('admin/procumerent', 'ProcumerentController')->middleware('admin');
Route::get('admin/procumerent/{id}/show', 'ProcumerentController@showing')->name('procumerent.showing')->middleware('admin');
Route::get('admin/procumerent/{id}/ubah-procumerent', 'ProcumerentController@profile')->name('procumerent.edit')->middleware('admin');
Route::post('admin/procumerent/{id}/ubah-procumerent', 'ProcumerentController@updatedong')->name('procumerent-update')->middleware('admin');


// Vendor
Route::resource('admin/vendor', 'VendorController')->middleware('admin');
Route::get('admin/vendor/{id}/show', 'VendorController@showing')->name('vendor.showing')->middleware('admin');
Route::get('admin/vendor/{id}/ubah-vendor', 'VendorController@profile')->name('vendor.edit')->middleware('admin');
Route::post('admin/vendor/{id}/ubah-vendor', 'VendorController@updatedong')->name('vendor-update')->middleware('admin');


// MASYARAKAT
Route::resource('admin/masyarakat', 'MasyarakatController')->middleware('admin');
Route::get('admin/masyarakat/{id}/show', 'MasyarakatController@showing')->name('masyarakat.showing')->middleware('admin');
Route::get('admin/masyarakat/{id}/ubah-masyarakat', 'MasyarakatController@profile')->name('masyarakat.edit')->middleware('admin');
Route::post('admin/masyarakat/{id}/ubah-masyarakat', 'UserController@updatedong')->name('masyarakat-update')->middleware('admin');

// PDF LAPOPORAN CEKTAK
Route::resource('admin/laporan', 'LaporanController')->middleware('admin');
Route::get('pengaduan_pdf/cetak_pdf', 'LaporanController@cetak_pdf')->name('cetak-laporan');


// // INI MIDDLEWARE Accounting
// // DASHBOARD
Route::get('accounting/dashboard', 'AccountingController@index2')->name('accounting/dashboard');
Route::get('accounting/po', 'AccountingController@po');

Route::get('accounting/invoice', 'AccountingController@invoice')->name('accounting/invoice');
Route::get('accounting/detail-invoice/{id}', 'AccountingController@detailinvoice')->name('accounting-invoice');

Route::get('accounting/user/{id}/show', 'AccountingController@showing')->name('accounting-user.show');


// // INI MIDDLEWARE Procumerent
Route::get('procumerent/dashboard', 'ProcumerentController@index2')->name('procurement/dashboard');
Route::get('procumerent/po', 'ProcumerentController@po');

Route::get('procumerent/user/{id}/show', 'ProcumerentController@showing')->name('procumerent-user.show');

// // INI MIDDLEWARE Warehouse
Route::get('warehouse/dashboard', 'WarehouseController@index2')->name('warehouse/dashboard');
Route::get('warehouse/po', 'WarehouseController@po');

Route::get('warehouse/user/{id}/show', 'WarehouseController@showing')->name('warehouse-user.show');

Route::get('warehouse/invoice', 'WarehouseController@invoice')->name('warehouse/invoice');
Route::get('warehouse/detail-invoice/{id}', 'WarehouseController@detailinvoice')->name('detail-invoice');

Route::post('warehouse/edit-datagr}','PoController@edit')->name('update-datagr/{id}');
Route::post('warehouse/updated-datagr','PoController@store')->name('update-datagr');


// // INI MIDDLEWARE Vendor
Route::get('vendor/dashboard', 'VendorController@index2')->name('vendor/dashboard');
Route::get('vendor/purchaseorder', 'VendorController@po');
Route::post('vendor/purchaseorder/{id}','VendorController@delete')->name('vendor-purchaseorder')->middleware('vendor');
Route::get('vendor/createpo', 'VendorController@createpo')->name('vendor/createpo');

Route::get('vendor/product', 'VendorController@product')->name('vendor/product');
Route::get('vendor/createproduct', 'VendorController@createproduct')->name('vendor/createproduct');

Route::post('vendor/dispute-datagr}','VendorController@edit')->name('dispute-datagr-vendor/{id}');

Route::post('vendor/edit-datagr}','VendorController@edit')->name('update-datagr-vendor/{id}');
Route::post('vendor/updated-datagr','VendorController@store')->name('update-datagr-vendor');

Route::get('vendor/invoice', 'VendorController@invoice')->name('vendor/invoice');
Route::get('vendor/detail-invoice/{id}', 'VendorController@detailinvoice')->name('detail-invoice');

Route::get('vendor/user/{id}/show', 'VendorController@showing')->name('vendor-user.show');
Route::get('vendor/user/{id}/profile', 'VendorController@show')->name('vendor-user.showing');
Route::post('vendor/{id}/profile','VendorController@heyupdate')->name('update-vendor');






// // // PENGUMUMAN
// Route::get('petugas/pengumuman', 'PetugasPengumumanController@index')->middleware('petugas');
// Route::get('petugas/pengumuman/{id}/show', 'PetugasPengumumanController@showing')->name('petuags-pengumuman.showing')->middleware('petugas');
// // // USER
// Route::post('petugas/{id}/profile','UserController@heyupdate')->name('update-ptgs')->middleware('petugas');
// Route::get('petugas/user/{id}/profile', 'PetugasUserController@showing')->name('petugas-user.showing')->middleware('petugas');
// Route::get('petugas/user/{id}/show', 'PetugasUserController@show')->name('petugas-user.show')->middleware('petugas');
// // // PENGADUAN - TANGGAPAN
// Route::get('petugas/pengaduan', 'PetugasPengaduanController@index')->middleware('petugas');
// Route::get('petugas/pengaduan/{id}/show/', 'PetugasPengaduanController@showing')->name('petugas-tanggapan.showing')->middleware('petugas');
// Route::post('petugas/pengaduan/{id}','PetugasPengaduanController@delete')->name('pengaduan-petugas.delete')->middleware('petugas');
// Route::post('petugas/pengaduan/{id}/show','PetugasPengaduanController@update')->name('pengaduan-petugas.update')->middleware('petugas');

// // // KOMENTAR
// Route::get('petugas/komentar', 'PetugasKomentarController@index')->middleware('petugas');
// Route::post('petugas/komentar/{id}','PetugasKomentarController@delete')->name('komentar-petugas')->middleware('petugas');
