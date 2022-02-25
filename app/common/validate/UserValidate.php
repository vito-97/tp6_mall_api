<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/22
 * Time: 16:15
 */

namespace app\common\validate;


class UserValidate extends BaseValidate
{
    protected $rule = [
        'username|账号' => 'require|alphaDash|unique:user|length:4,20',
        'nickname|昵称' => 'require|chsDash|length:1,20',
        'phone|手机号'   => 'require|mobile',
        'code|验证码'    => 'require|integer',
        'sex|性别'      => 'require|in:0,1,2',
    ];

    protected $scene = [
        'login'  => ['phone', 'code'],
        'update' => ['nickname', 'sex', 'username'],
    ];
}