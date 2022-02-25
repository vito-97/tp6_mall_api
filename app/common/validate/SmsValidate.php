<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 11:32
 */

namespace app\common\validate;


class SmsValidate extends BaseValidate
{
    protected $rule = [
        'phone|手机号' => 'require|mobile',
        'scene|场景'  => 'checkScene',
    ];

    protected $scene = [
        'send_code' => ['phone', 'scene'],
    ];

    protected function checkScene($value)
    {
        return in_array($value, config('sms.scene')) ?: ':attribute错误';
    }
}