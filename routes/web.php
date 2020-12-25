<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/produk/{nama}.{price}/{referal}', 'ProductControlller@detailProduk');
Route::get('/register/{kode}', 'UserController@index');
Route::get('/password/{kode}', 'UserController@password');
Route::get('/invoice/{kode}.{invoice}', 'UserController@invoice');
Route::get('/produk/{nama}.{produk}/{price}/{referal}', 'ProductControlller@penjualanProduk');
Route::post('/password/{user}', 'UserController@changePassword')->name('user.password');
Route::post('/pembelian', 'ProductControlller@pembelian')->name('user.pembelian');
Route::post('/daftar', 'UserController@daftar')->name('user.daftar');
Route::get('/card/{user}', 'UserController@card')->name('user.card');

Auth::routes();

Route::group(['prefix' => 'admin','middleware' => ['admin']], function () {
    Route::get('/dashboard','HomeController@mainAdmin')->name('admin.dashboard');
    Route::get('/referral','HomeController@referral')->name('admin.referral');
    Route::get('/referral/{member}','HomeController@referralDetail')->name('admin.referral.detail');
    Route::get('/activity','HomeController@activity')->name('admin.activity');
    Route::get('/customer','HomeController@customer')->name('admin.customer');
    Route::get('/customer/{customer}','HomeController@detailCustomer')->name('admin.customer.detail');
    Route::delete('/customer/{customer}','HomeController@destroyCustomer')->name('admin.customer.destroy');
    Route::delete('/delete/target/{target}','HomeController@destroyTarget')->name('admin.target.destroy');
    Route::post('/update/target/{target}','HomeController@updateTarget')->name('admin.target.update');
    Route::get('/profile','HomeController@profile')->name('admin.profile');
    Route::get('/promosi','HomeController@promosi')->name('admin.promosi');
    Route::get('/promosi/{produk}','HomeController@promosiPenjualan')->name('admin.promosi.penjualan');
    Route::resource('produk', 'Admin\ProductController');
    Route::resource('member', 'Admin\MemberController');
    Route::resource('invoice', 'Admin\InvoiceController');
    Route::resource('withdraw', 'Admin\WithdrawController');
    Route::post('passwordReset', 'Admin\MemberController@resetPassword')->name('admin.resetPassword');
    Route::post('pendapatanReset/{member}', 'Admin\MemberController@resetPendapatan')->name('admin.resetPendapatan');
    Route::post('updatePerusahaan/{perusahaan}', 'HomeController@updatePerusahaan')->name('admin.updatePerusahaan');
    Route::post('updateProfil', 'HomeController@updateProfil')->name('admin.updateProfil');
    Route::post('download', 'HomeController@download')->name('admin.download');
    Route::post('scanUser', 'Admin\WithdrawController@scanUser');
});

Route::group(['prefix'=>'member','middleware' => ['member']], function () {
    Route::get('/referral','HomeController@referralMember')->name('member.referral');
    Route::get('/referral/{member}','HomeController@referralDetail')->name('member.referral.detail');
    Route::get('/profile','HomeController@profileMember')->name('member.profile');
    Route::get('/dashboard','HomeController@mainMember')->name('member.dashboard');
    Route::get('/promosi','HomeController@promosi')->name('member.promosi');
    Route::get('/transaksi','HomeController@transaksi')->name('member.transaksi');
    Route::get('/transaksi/{invoice}','HomeController@transaksiDetail')->name('member.transaksi.detail');
    Route::get('/promosi/{produk}','HomeController@promosiPenjualan')->name('member.promosi.penjualan');
    Route::get('/produk/{produk}','Admin\ProductController@show')->name('member.produk.detail');
    Route::post('updateProfil', 'HomeController@updateProfil')->name('member.updateProfil');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
