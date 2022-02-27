<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/24
 */

namespace app\common\model\mysql;


class Product extends BaseModel
{
    protected $hidden = ['delete_time', 'main_img_id', 'pivot', 'from', 'category_id', 'create_time', 'update_time', 'img_id'];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function imgs()
    {
        return $this->belongsToMany('Image', 'ProductImage', 'img_id', 'product_id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }
}