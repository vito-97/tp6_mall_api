<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

namespace app\api\controller\v1;

use app\common\CodeMessage;
use app\common\logic\UserLogic;
use app\common\validate\UserValidate;
use app\api\controller\Base;

class Login extends Base
{
    public $noLoginRequired = true;

    public function index()
    {
        UserValidate::batchCheck('login');

        $code  = $this->request->param('code');
        $phone = $this->request->param('phone');

        $logic = new UserLogic();

        $status = $logic->login($phone, $code);

        if ( $status ) {
            return $this->success(['message' => '登录成功', 'data' => $status]);
        } else {
            return $this->error(['code' => CodeMessage::LOGIN_ERROR]);
        }
    }
}