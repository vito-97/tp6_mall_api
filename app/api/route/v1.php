<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/24
 */

use \think\facade\Route;

Route::group('<version>', function () {

    //发送短信
    Route::post('sms/send', 'Sms/send')->name('sendSms');

    //获取Banner
    Route::get('banner/<id>', 'Banner/read');

    //主题
    Route::group('theme', function () {
        Route::get('/', 'index');
        Route::get('<id>', 'read');
        Route::post('<t_id>/product/<p_id>', 'createThemeProduct');
        Route::delete('<t_id>/product/<p_id>', 'deleteThemeProduct');
    })->prefix('Theme/');

    //商品
    Route::group('product', function () {
        Route::get('', 'index');
        Route::get('all', 'all');
        Route::get('recent', 'recent');
        Route::post('', 'create');
        Route::get('<id>', 'read');
        Route::delete('<id>', 'delete');
    })->prefix('Product/');

    //分类
    Route::group('category', function () {
        Route::get('', 'index');
        Route::get('all', 'all');
    })->prefix('Category/');

    //令牌
    Route::group('token', function () {
        Route::post('user', 'getToken');
        Route::post('app', 'getAppToken');
        Route::post('verify', 'verifyToken');
    })->prefix('Token/');

    //登出
    Route::post('logout', 'Logout/index');

    //地址
    Route::group('address', function () {
        Route::get('', 'index');
        Route::post('', 'createOrUpdateAddress');
    })->prefix('Address/');

    //订单
    Route::group('order', function () {
        Route::get('', 'index');
        Route::get('<id>', 'read');
        Route::post('', 'place');
        Route::put('delivery', 'delivery');
    })->prefix('Order/');

    //支付
    Route::group('pay', function () {
        Route::post('pre_order', 'getPreOrder');
        Route::post('notify', 'receiveNotify');
        Route::post('re_notify', 'redirectNotify');
        Route::post('concurrency', 'notifyConcurrency');
    })->prefix('Pay/');


})->prefix('<version>.')->pattern(['id' => '\d+'])->allowCrossDomain();//允许跨域