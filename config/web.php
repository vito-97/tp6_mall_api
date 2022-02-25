<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 14:16
 */
$host = $_SERVER['HTTP_HOST'] ?? '';
return [
    //是否是本地开发
    'is_local'             => $host === 'tp6.cn',

    //图片地址
    'img_host'             => "http://{$host}/static/images",

    //短信测试
    'sms_test'             => true,
    //加密盐
    'salt'                 => [
        'password' => '1qazXSW@3edcVFR$',
        'token'    => 'asdkfjderop*^%$3xfbh',
        'jwt'      => 'KzcZmsWtKvEx@IikLrO$jK1ZJrsgWiFT',
    ],

    //响应类型key
    'api_response_key'     => 'response_type',
    'api_default_response' => 'json',
];
