<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\validate;


class ThemeValidate extends BaseValidate
{
    protected $rule = [
        'p_id|商品ID' => 'require|isPositiveInteger',
        't_id|主题ID' => 'require|isPositiveInteger',
    ];

    protected $scene = [
        'create' => ['p_id', 't_id'],
        'delete' => ['p_id', 't_id'],
    ];
}