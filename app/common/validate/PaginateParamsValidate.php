<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 14:08
 */

namespace app\common\validate;


class PaginateParamsValidate extends BaseValidate
{
    protected $rule = [
        'page|页码' => 'isPositiveInteger',
        'size|数量' => 'isPositiveInteger',
    ];

    protected $scene = [
        'size' => ['size'],
    ];
}