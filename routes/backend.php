<?php

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::namespace('Backend')->name('backend.')->group(function () {
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
    // 模块管理
    Route::prefix('module')->controller('ModuleController')->name('module.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 策略管理
    Route::prefix('policy')->controller('PolicyController')->name('policy.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 角色管理
    Route::prefix('role')->controller('RoleController')->name('role.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 管理员
    Route::prefix('manager')->controller('ManagerController')->name('manager.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'updatePassword')->name('password');
    });
    // 行业管理
    Route::prefix('industry')->controller('IndustryController')->name('industry.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
});
