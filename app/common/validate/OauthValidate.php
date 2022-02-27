<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\validate;


class OauthValidate extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty',
        'token' => 'require|isNotEmpty'
    ];

    protected $scene = [
        //获取token场景
        'code' => ['code'],
        'token' => ['token']
    ];
}