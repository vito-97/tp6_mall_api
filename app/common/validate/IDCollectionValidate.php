<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 10:41
 */

namespace app\common\validate;


class IDCollectionValidate extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIds',
    ];
}