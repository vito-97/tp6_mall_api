<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/24
 * Time: 16:30
 */

namespace app\common\model\mysql;


class BannerItem extends BaseModel
{
    protected $hidden = ['id', 'img_id', 'banner_id', 'delete_time'];

    /**
     * 关联图片
     * @return \think\model\relation\BelongsTo
     */
    public function img()
    {
        return $this->belongsTo('Image', 'img_id');
    }
}