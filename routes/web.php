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
    return view('welcome');
});
Route::namespace('Utils')->name('utils.')->group(function () {
    // 验证码
    Route::controller('CaptchaController')->group(function () {
        Route::get('captcha/{captcha?}', 'captcha')->name('captcha')->whereAlpha('captcha');
    });
    // 图片上传
    Route::prefix('upload')->controller('UploadController')->name('upload.')->group(function () {
        Route::post('images', 'images')->name('images');
    });
});
