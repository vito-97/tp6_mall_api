<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

namespace app\common\model\mysql;


class Category extends BaseModel
{
    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id');
    }
}