<?php


namespace app\api\traits;


use app\common\logic\UserLogic;
use app\common\model\mysql\User;
use think\facade\Request;

trait UserTrait
{
    protected static $user = [];

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
            self::$user = \request()->USER;
        }

        if ( $now && !empty(self::$user['id']) && !self::$user instanceof User) {
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
}