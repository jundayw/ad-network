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
    // 广告尺寸
    Route::prefix('size')->controller('SizeController')->name('size.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 广告主
    Route::prefix('advertisement')->controller('AdvertisementController')->name('advertisement.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 广告主账户
    Route::prefix('advertiser')->controller('AdvertiserController')->name('advertiser.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 广告创意
    Route::prefix('creative')->controller('CreativeController')->name('creative.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 广告单元
    Route::prefix('element')->controller('ElementController')->name('element.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 广告计划
    Route::prefix('program')->controller('ProgramController')->name('program.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 流量主账户
    Route::prefix('publisher')->controller('PublisherController')->name('publisher.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 流量主
    Route::prefix('publishment')->controller('PublishmentController')->name('publishment.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 广告位
    Route::prefix('adsense')->controller('AdsenseController')->name('adsense.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 站点
    Route::prefix('site')->controller('SiteController')->name('site.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 广告物料
    Route::prefix('material')->controller('MaterialController')->name('material.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
    // 资金管理
    Route::prefix('deposit')->controller('DepositController')->name('deposit.')->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy')->name('destroy');
    });
});
