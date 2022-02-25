<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 10:09
 */

namespace app\api\controller;

use app\BaseController;
use app\common\CodeMessage;
use app\common\logic\UserLogic;
use app\common\traits\AppTrait;

abstract class Base extends BaseController
{
    use AppTrait;

    //不需要登陆的方法
    public $exceptLogin = [];

    //是否整个控制器都不需要登陆
    public $noLoginRequired = false;

    protected static $user = [];

    public function __call($method, $args)
    {
        return $this->error(['code' => CodeMessage::NOT_FOUND_ACTION]);
    }

    /**
     * 获取用户信息
     * @param bool $now
     * @return \app\common\model\mysql\BaseModel|array|mixed|\think\Model|null
     * @throws \app\common\exception\ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUser($now = false)
    {
        if ( empty(self::$user) ) {
            self::$user = $this->request->USER;
        }

        if ( $now && !empty(self::$user['id']) ) {
            $logic = new UserLogic();

            $user = $logic->getLoginUserNow();

            self::$user = $user;
        }

        return self::$user;
    }

    /**
     * 获取UID
     * @return int|mixed
     * @throws \app\common\exception\ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUid()
    {
        $user = $this->getUser();

        return $user['id'] ?? 0;
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