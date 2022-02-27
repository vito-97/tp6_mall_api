<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\validate;

//ID必须为正整数验证器
class IDMustPositiveIntValidate extends BaseValidate
{
    protected $rule = [
        'id|ID' => 'require|isPositiveInteger',
    ];
}