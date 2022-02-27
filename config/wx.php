<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

return [
    // 小程序app_id
    'app_id'           => 'wx1cdd7b07080451de',
    // 小程序app_secret
    'app_secret'       => '9152cf4158decaecd5a954e29078bf8a',

    // 微信使用code换取用户openid及session_key的url地址
    'login_url'        => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",

    'pay_back_url' => 'https://mall.cn/api/v1/pay/notify',
];
