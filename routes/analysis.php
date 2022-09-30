<?php

/*
|--------------------------------------------------------------------------
| Analysis Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::namespace('Analysis')->name('analysis.')->group(function () {
    Route::prefix('analysis')->controller('AnalysisController')->name('analysis.')->group(function () {
        Route::get('review', 'review')->name('review')->middleware('signed');
        Route::get('redirect', 'redirect')->name('redirect')->middleware('signed');
    });
});
