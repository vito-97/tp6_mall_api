<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
use app\common\logic\UserLogic;
use app\common\validate\OauthValidate;

class Token extends Base
{
    public $noLoginRequired = true;

    /**
     * 获取登录token
     * @url /token
     * @param string $code
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function getToken($code = '')
    {
        OauthValidate::batchCheck('code');

        $logic = $this->getLogic();

        $token = $logic->getToken($code);

        $data = [
            'token' => $token,
        ];

        return $this->success(['data' => $data]);
    }

    /**
     * 验证token是否有效
     * @url /token/verify
     * @param string $token
     * @return mixed
     * @throws \app\common\exception\ValidateException
     */
    public function verifyToken($token = ''){
        OauthValidate::batchCheck('token');

        $user = (new UserLogic())->getLoginUser($token);

        $data = [
            'is_valid' => !!$user
        ];

        return $this->success([
            'data' => $data
        ]);
    }
}