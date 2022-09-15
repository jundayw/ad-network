<?php

/*
|--------------------------------------------------------------------------
| Publishment Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::namespace('Publishment')->name('publishment.')->group(function () {
    // 账户登录
    Route::controller('AccountController')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('verify', 'verify')->name('verify');
        Route::get('logout', 'logout')->name('logout');
    });
    // 我的桌面
    Route::controller('IndexController')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('clear', 'clear')->name('clear');
    });
    // 个人中心
    Route::prefix('profile')->controller('ProfileController')->name('profile.')->group(function () {
        Route::get('password', 'password')->name('password');
        Route::post('password', 'password')->name('password');
    });
});
