<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

namespace app\api\controller;

use app\api\traits\UserTrait;
use app\BaseController;
use app\common\CodeMessage;
use app\common\traits\AppTrait;

abstract class Base extends BaseController
{
    use AppTrait,UserTrait;

    //不需要登陆的方法
    public $exceptLogin = [];

    //是否整个控制器都不需要登陆
    public $noLoginRequired = false;

    public function __call($method, $args)
    {
        return $this->error(['code' => CodeMessage::NOT_FOUND_ACTION]);
    }

    /**
     * 获取ID集合
     * @return array|mixed
     */
    protected function getIds()
    {
        $value = explode(',', $this->request->param('ids', ''));

        if ( !$value ) return [];

        $value = array_map(function($item) {
            return (int)$item;
        }, $value);

        return $value;
    }

    protected function getPage($default = 1)
    {
        $page = $this->request->param('page', $default, 'intval');

        return $page;
    }

    protected function getSize($default = 30)
    {
        $size = $this->request->param('size', $default, 'intval');

        $max = (int)config('setting.page.max_size') ?? 100;

        if ( $size > $max ) {
            $size = $max;
        }

        return $size;
    }
}