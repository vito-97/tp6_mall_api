<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 16:04
 */

namespace app\common\validate;


class OauthValidate extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $scene = [
        //获取token场景
        'token' => ['code'],
    ];
}