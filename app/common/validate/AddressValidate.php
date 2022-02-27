<?php


namespace app\common\validate;


class AddressValidate extends BaseValidate
{
    protected $rule = [
        'name|姓名'     => 'require|isNotEmpty',
        'mobile|手机'   => 'require',
        'province|省' => 'require|isNotEmpty',
        'city|城市'     => 'require|isNotEmpty',
        'country|国家'  => 'require|isNotEmpty',
        'detail|详情'   => 'require|isNotEmpty',
    ];

    protected $scene = [

    ];
}