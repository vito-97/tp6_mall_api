<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/24
 * Time: 16:30
 */

namespace app\common\model\mysql;


class Banner extends BaseModel
{
    /**
     * 关联
     * @return \think\model\relation\HasMany
     */
    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
}