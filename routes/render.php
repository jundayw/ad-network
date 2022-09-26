<?php

/*
|--------------------------------------------------------------------------
| Render Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::namespace('Render')->name('render.')->group(function () {
    Route::prefix('adsense')->controller('AdsenseController')->name('adsense.')->group(function () {
        Route::post('/', 'network')->name('network');
        Route::get('render', 'render')->name('render')->middleware('signed');
    });
});
