<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 16:01
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
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
        OauthValidate::batchCheck('token');

        $logic = $this->getLogic();

        $token = $logic->getToken($code);

        $data = [
            'token' => $token,
        ];

        return $this->success(['data' => $data]);
    }
}