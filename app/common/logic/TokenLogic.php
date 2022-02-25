<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 16:33
 */

namespace app\common\logic;


use app\api\event\Login as LoginEvent;
use app\common\CodeMessage;
use app\common\exception\ErrorException;
use app\common\lib\WeiXin;
use think\facade\Event;

class TokenLogic extends BaseLogic
{
    /**
     * 获取登录token
     * @param $code
     * @return mixed
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getToken($code)
    {
        $wxUser = $this->getWxUser($code);

        $userLogic = new UserLogic();

        ['user' => $user, 'token' => $token] = $userLogic->login($wxUser['openid']);

        return $token;
    }

    /**
     * 获取微信用户信息
     * @param $code
     * @return mixed
     * @throws \app\common\exception\ErrorException
     */
    public function getWxUser($code)
    {
        $wx = new WeiXin();

        $result = $wx->getUserInfo($code);

        return $result;
    }
}