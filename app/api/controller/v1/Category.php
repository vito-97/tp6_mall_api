<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/22
 * Time: 15:02
 */

namespace app\api\controller\v1;

use app\api\controller\Base;
use app\common\CodeMessage;
use app\common\exception\NotExistsException;

class Category extends Base
{
    public $noLoginRequired = true;

    /**
     * 获取分类结构树
     * @return mixed
     * @throws \app\common\exception\ErrorException
     */
    public function index()
    {
        $lists = $this->getLogic()->lists($this->getPage(), $this->getSize());

        if ( empty($lists) ) {
            throw new NotExistsException(CodeMessage::CATEGORY_EMPTY);
        }

        return $this->success(['data' => $lists]);
    }

    /**
     * 获取分类结构树
     * @return mixed
     * @throws \app\common\exception\ErrorException
     */
    public function all()
    {
        $lists = $this->getLogic()->lists(false);

        if ( empty($lists) ) {
            throw new NotExistsException(CodeMessage::CATEGORY_EMPTY);
        }

        return $this->success(['data' => $lists]);
    }
}