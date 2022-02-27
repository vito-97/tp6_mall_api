<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\logic;


class BannerLogic extends BaseLogic
{
    /**
     * 通过id获取banner
     * @param $id
     * @return \app\common\model\mysql\BaseModel|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getBannerById($id)
    {
        $args = [
            'with' => ['items', 'items.img']
        ];

        return $this->getModel()->getByID($id, $args);
    }
}