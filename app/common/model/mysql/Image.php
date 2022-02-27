<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/24
 */

namespace app\common\model\mysql;


class Image extends BaseModel
{
    protected $hidden = ['pivot','from','delete_time'];

    /**
     * 地址获取器
     * @param $value
     * @param $data
     * @return string
     */
    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}