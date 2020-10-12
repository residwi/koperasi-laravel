<?php

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
    return redirect('login');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// verifikasi untuk lengkapi data diri anggota
Route::group(['middleware' => ['auth']], function () {
    Route::get('daftar-anggota', 'HomeController@formAnggota')->name('daftar-anggota');
    Route::post('daftar-anggota', 'HomeController@complete');
});

Route::group(['middleware' => ['auth', 'daftar_anggota']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resources([
        'simpanan' => 'SimpananController',
        'pinjaman' => 'PinjamanController',
    ]);

    Route::resource('anggota', 'AnggotaController')->only('index');
    Route::resource('pinjaman.angsuran', 'AngsuranController')->shallow();
});

Route::get('api/laporan', 'HomeController@apiLaporan');
Route::get('api/anggota/{id}', 'AnggotaController@api');