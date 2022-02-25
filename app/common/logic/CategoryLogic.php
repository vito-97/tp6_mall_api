<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 16:09
 */

namespace app\common\logic;

class CategoryLogic extends BaseLogic
{
    public function lists($page = 1, $size = 0)
    {
        $size = $this->getSize($size);

        $args = [
            'with' => 'img',
            'page' => $page,
            'size' => $size,
        ];

        return $this->getModel()->getLists($args);
    }
}