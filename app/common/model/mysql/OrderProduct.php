<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/24
 */

namespace app\common\model\mysql;


use think\model\Pivot;

class OrderProduct extends Pivot
{
    protected $autoWriteTimestamp = true;
}