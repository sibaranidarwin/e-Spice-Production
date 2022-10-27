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

// Purchase Order
Route::get('admin/po', 'AdminController@po')->name('admin/po')->middleware('admin');
Route::get('admin/pover', 'AdminController@pover')->name('admin/pover')->middleware('admin');
Route::get('admin/poreject', 'AdminController@poreject')->name('admin/poreject')->middleware('admin');

//BA
Route::get('admin/draft', 'AdminController@draft')->name('admin/draft');
Route::get('admin/ba', 'AdminController@ba')->name('admin/ba');
Route::put('admin/draft','AdminController@uploaddraft');

// Invoice 
Route::get('admin/invoice', 'AdminController@invoice')->middleware('admin');
Route::get('admin/detail-invoice/{id}', 'AdminController@detailinvoice')->name('detail-invoice');
Route::get('admin/cetak_pdf/{id}', 'AdminController@cetak_pdf')->name('cetak-laporan');

Route::get('admin/invoiceba', 'AdminController@invoiceba')->name('admin/invoiceba');
Route::get('admin/detail-invoice-ba/{id}', 'AdminController@detailinvoiceba')->name('detail-invoice');
Route::get('admin/cetak_pdf/{id}', 'AdminController@cetak_pdf')->name('cetak-laporan');

//Pruchase order disputed
Route::get('admin/disputed', 'AdminController@disputed')->middleware('admin');

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
Route::get('warehouse/pover', 'WarehouseController@pover');
Route::get('warehouse/poreject', 'WarehouseController@poreject');


Route::get('warehouse/invoice', 'WarehouseController@invoice')->name('warehouse/invoice');
Route::get('warehouse/detail-invoice/{id}', 'WarehouseController@detailinvoice')->name('detail-invoice');
Route::get('warehouse/invoiceba', 'WarehouseController@invoiceba')->name('warehouse/invoiceba');
Route::get('warehouse/detail-invoice-ba/{id}', 'WarehouseController@detailinvoiceba')->name('detail-invoice-ba');

Route::get('warehouse/disputed', 'WarehouseController@disputed')->name('warehouse/disputed');

Route::post('warehouse/edit-datagr','PoController@edit')->name('update-datagr/{id}');
Route::post('warehouse/updated-datagr','PoController@update')->name('update-datagr');

Route::get('warehouse/user/{id}/show', 'WarehouseController@showing')->name('warehouse-user.show');
Route::get('warehouse/user/{id}/profile', 'WarehouseController@show')->name('warehouse-user.showing');
Route::put('warehouse/{id}/profile','WarehouseController@heyupdate')->name('update-warehouse');
Route::post('warehouse/{id}/password','WarehouseController@editpass')->name('update-pass-warehouse');


// // INI MIDDLEWARE Vendor
Route::get('vendor/dashboard', 'VendorController@index2')->name('vendor/dashboard');
Route::get('vendor/purchaseorder', 'VendorController@po');
Route::get('vendor/puchaseorderreject', 'VendorController@puchaseorderreject');

Route::post('vendor/dispute-datagr','VendorController@edit')->name('dispute-datagr-vendor/{id}');

Route::post('vendor/edit-datagr','VendorController@edit')->name('update-datagr-vendor/{id_gr}');
Route::post('vendor/update-datagr','VendorController@update')->name('dispute_datagr');
Route::post('vendor/create_invoice','VendorController@store')->name('create-invoice');

Route::get('vendor/draft', 'VendorController@draft')->name('vendor/draft');
Route::get('vendor/ba', 'VendorController@ba')->name('vendor/ba');
Route::put('vendor/draft','VendorController@uploaddraft');

Route::post('vendor/edit-ba','VendorController@editba')->name('update-ba-vendor/{id_gr}');
Route::post('vendor/create_invoice_ba','VendorController@storeba')->name('create-invoice-ba');

Route::get('vendor/invoice', 'VendorController@invoice')->name('vendor/invoice');
Route::get('vendor/detail-invoice/{id}', 'VendorController@detailinvoice')->name('detail-invoice');
Route::get('vendor/cetak_pdf/{id}', 'VendorController@cetak_pdf')->name('cetak-laporan');

Route::get('vendor/invoiceba', 'VendorController@invoiceba')->name('vendor/invoiceba');
Route::get('vendor/detail-invoice-ba/{id}', 'VendorController@detailinvoiceba')->name('detail-invoice-ba');
Route::get('vendor/cetak_pdf_ba/{id}', 'VendorController@cetak_pdf_ba')->name('cetak-laporan-ba');

Route::get('vendor/disputed', 'VendorController@disputed')->name('vendor/disputed');

Route::get('vendor/user/{id}/show', 'VendorController@showing')->name('vendor-user.show');
Route::get('vendor/user/{id}/profile', 'VendorController@show')->name('vendor-user.showing');
Route::put('vendor/{id}/profile','VendorController@heyupdate')->name('update-vendor');
Route::post('vendor/{id}/password','VendorController@editpass')->name('update-pass-vendor');
