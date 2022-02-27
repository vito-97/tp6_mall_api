<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\validate;


class IDCollectionValidate extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIds',
    ];
}