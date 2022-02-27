<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/22
 */

namespace app\common\logic;


use app\api\event\Login as LoginEvent;
use app\common\CodeMessage;
use app\common\exception\ErrorException;
use app\common\lib\Password;
use app\common\model\mysql\User;
use think\facade\Event;
use think\facade\Request;

class UserLogic extends BaseLogic
{
    //设置驱动类型
    protected $cacheStore = 'redis';

    /**
     * 用户登录
     * @param $phone 手机号
     * @param $code 验证码
     * @return array
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function phoneLogin($phone, $code)
    {
        $scene = 'login';
        //校验验证码
        $smsLogic = new SmsLogic();
        $status   = $smsLogic->validate($phone, $code, $scene);
        if ( !$status ) throw new ErrorException(CodeMessage::SMS_VALIDATE_ERROR);
        //检测用户
        $user = $this->getByPhone($phone);

        if ( !$user ) {

            //添加用户
            $data = [
                'phone'    => $phone,
                'username' => 'mall_' . $phone,
                'nickname' => '维多商城' . time() . rand(1000, 9999),
                'status'   => 1,
            ];
            $user = $this->create($data);

            if ( !$user ) {
                throw new ErrorException(CodeMessage::USER_REGISTER_ERROR);
            }
        }

        if ( !$user->status ) throw new ErrorException(CodeMessage::USER_DISABLED);

        Event::trigger(new LoginEvent($user));

        $user = $user->visible(['id', 'username', 'phone', 'nickname']);
        //生成token
        $token = $this->createLoginToken();
        //设置登录用户
        $this->setLoginUser($token, $user);
        //删除验证码缓存
        $smsLogic->deleteCode($phone, $scene);

        return ['token' => $token, 'user' => $user];
    }

    /**
     * 登录
     * @param $openID
     * @return array
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login($openID)
    {
        $user = $this->getByOpenID($openID);

        if ( !$user ) {
            $user = $this->createUserByOpenID($openID);
        }

        if ( !$user->status ) throw new ErrorException(CodeMessage::USER_DISABLED);

        Event::trigger(new LoginEvent($user));

        $user = $user->visible(['id', 'username', 'phone', 'nickname','openid']);
        //生成token
        $token = $this->createLoginToken();
        //设置登录用户
        $this->setLoginUser($token, $user->toArray());

        return ['token' => $token, 'user' => $user];
    }

    /**
     * 创建用户
     * @param $openID
     * @return \app\common\model\mysql\BaseModel|bool|false
     */
    public function createUserByOpenID($openID)
    {
        return $this->create(['openid' => $openID, 'status' => User::STATUS_ON]);
    }

    /**
     * 设置登录用户
     * @param $token
     * @param $user
     * @return $this
     */
    public function setLoginUser($token, $user)
    {
        $this->getCache()->set($token, $user);
        return $this;
    }

    /**
     * 登出
     * @param $token
     * @return bool
     */
    public function logout($token = '')
    {
        if ( !$token ) {
            $token = $this->getLoginToken();
        }
        if ( $token )
            return $this->getCache()->delete($token);
        return false;
    }

    /**
     * 获取登录用户
     * @param string $token
     * @return bool|mixed
     */
    public function getLoginUser($token = '')
    {
        if ( !$token ) {
            $token = $this->getLoginToken();
        }

        if ( empty($token) ) {
            return false;
        }

        $user = $this->getCache()->get($token);

        return empty($user['id']) ? false : $user;
    }

    /**
     * 获取数据库的用户
     * @return \app\common\model\mysql\BaseModel|array|mixed|\think\Model|null
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getLoginUserNow()
    {
        static $user;

        if ( empty($user) ) {
            $_user = $this->getLoginUser();

            if ( $_user && isset($_user['id']) ) {
                $_user = $this->getModel()->getByID($_user['id']);

                if ( empty($_user) ) {
                    throw new ErrorException(CodeMessage::USER_NOT_FOUND);
                }

                if ( !$_user->status ) {
                    throw new ErrorException(CodeMessage::USER_DISABLED);
                }

                $user = $_user;
            }
        }

        return $user;
    }

    /**
     * 获取登录token
     * @return array|string
     */
    public function getLoginToken()
    {
        $token = Request::header('token',Request::param('token')) ;

        return $token;
    }

    /**
     * 获取token
     * @return string
     */
    public function createLoginToken()
    {
        $token = Password::encrypt(uniqid(), 'token');

        return $token;
    }

    /**
     * 通过手机获取用户
     * @param $phone
     * @return \app\common\model\mysql\BaseModel|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByPhone($phone)
    {
        return $this->getOne('phone', $phone);
    }

    /**
     * 通过openID获取用户
     * @param $openID
     * @return \app\common\model\mysql\BaseModel|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByOpenID($openID)
    {
        return $this->getOne('openid', $openID);
    }


}