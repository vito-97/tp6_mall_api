<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/24
 * Time: 16:32
 */

namespace app\common\model\mysql;


class Theme extends BaseModel
{
    protected $hidden = ['delete_time', 'topic_img_id', 'head_img_id'];

    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id');
    }

    /**
     * 多对多关联
     * @return \think\model\relation\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('Product', 'ThemeProduct', 'product_id', 'theme_id');
    }
}