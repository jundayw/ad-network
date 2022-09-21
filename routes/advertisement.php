<?php

/*
|--------------------------------------------------------------------------
| Advertisement Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::namespace('Advertisement')->name('advertisement.')->group(function () {
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
    // 广告计划
    Route::prefix('program')->controller('ProgramController')->name('program.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
    });
    // 广告单元
    Route::prefix('element')->controller('ElementController')->name('element.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
    });
    // 广告创意
    Route::prefix('creative')->controller('CreativeController')->name('creative.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit')->middleware('signed');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy')->middleware('signed');
    });
});
