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
        Route::get('signup', 'signup')->name('signup');
        Route::post('register', 'register')->name('register');
        Route::post('mail', 'mail')->name('mail');
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
        Route::get('info', 'info')->name('info');
        Route::post('info', 'info')->name('info');
    });
    // 站点管理
    Route::prefix('site')->controller('SiteController')->name('site.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('verify', 'verify')->name('verify');
        Route::post('verification', 'verification')->name('verification');
        Route::get('download', 'download')->name('download');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
    });
    // 频道管理
    Route::prefix('channel')->controller('ChannelController')->name('channel.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
    });
    // 广告位管理
    Route::prefix('adsense')->controller('AdsenseController')->name('adsense.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
        Route::get('code', 'code')->name('code')->middleware('signed');
    });
    // 广告物料
    Route::prefix('material')->controller('MaterialController')->name('material.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
    });
    // 账户管理
    Route::prefix('publisher')->controller('PublisherController')->name('publisher.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
        Route::get('password', 'password')->name('password')->middleware('signed');
        Route::post('password', 'updatePassword')->name('updatePassword');
    });
    // 财务管理
    Route::prefix('deposit')->controller('DepositController')->name('deposit.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('recharge', 'recharge')->name('recharge');
        Route::post('store', 'store')->name('store');
        Route::get('withdraw', 'withdraw')->name('withdraw');
        Route::post('update', 'update')->name('update');
    });
});
