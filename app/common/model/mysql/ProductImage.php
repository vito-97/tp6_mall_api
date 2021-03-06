<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/24
 */

namespace app\common\model\mysql;


use think\model\Pivot;

class ProductImage extends Pivot
{
    protected $autoWriteTimestamp = true;

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}