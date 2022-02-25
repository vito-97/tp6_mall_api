<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/24
 * Time: 16:44
 */

use \think\facade\Route;

Route::group('<version>', function() {

    //发送短信
    Route::post('sms/send', 'Sms/send')->name('sendSms');

    //获取Banner
    Route::get('banner/<id>', 'Banner/read');

    //主题
    Route::group('theme', function() {
        Route::get('/', 'index');
        Route::get('<id>', 'read');
        Route::post('<t_id>/product/<p_id>', 'createThemeProduct');
        Route::delete('<t_id>/product/<p_id>', 'deleteThemeProduct');
    })->prefix('Theme/');

    //产品
    Route::group('product', function() {
        Route::get('', 'index');
        Route::get('all', 'all');
        Route::get('recent', 'recent');
        Route::post('', 'create');
        Route::get('<id>', 'read');
        Route::delete('<id>', 'delete');
    })->prefix('Product/');

    //分类
    Route::group('category', function() {
        Route::get('', 'index');
        Route::get('all', 'all');
    })->prefix('Category/');

    //令牌
    Route::group('token', function() {
        Route::post('user', 'getToken');
        Route::post('app', 'getAppToken');
        Route::post('verify', 'verifyToken');
    })->prefix('Token/');


})->prefix('<version>.')->pattern(['id' => '\d+']);