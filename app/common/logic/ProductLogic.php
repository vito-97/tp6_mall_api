<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 14:26
 */

namespace app\common\logic;


class ProductLogic extends BaseLogic
{
    /**
     * 获取
     * @param $id
     * @param int $page
     * @param int $size
     * @return \app\common\model\mysql\BaseModel[]|array|\think\Collection|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getProductsByCategoryID($id, $page = 1, $size = 0)
    {
        $size = $this->getSize($size);

        $args = [
            'where' => ['category_id' => $id],
            'page'  => $page,
            'size'  => $size
        ];

        return $this->getModel()->getLists($args, $page);
    }

    public function getMostRecent($size = 0)
    {
        $size = $this->getSize($size);

        $args = [
            'limit' => $size,
            'order' => ['create_time' => 'desc']
        ];

        return $this->getModel()->getLists($args, false);
    }

    public function getProductDetail($id)
    {
        $args = [
            'with' => [
                'imgs' => function($query) {
                },
                'properties'
            ]
        ];

        $result = $this->getModel()->getByID($id, $args);

        return $result;
    }
}