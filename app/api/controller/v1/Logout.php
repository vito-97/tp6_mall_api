<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/23
 */

namespace app\api\controller\v1;

use app\common\CodeMessage;
use app\common\logic\UserLogic;
use app\api\controller\Base;

class Logout extends Base
{
    public function index()
    {
        $logic = new UserLogic();

        $status = $logic->logout();

        if ( $status ) {
            return $this->success(['msg' => 'η»εΊζε']);
        }else{
            return $this->error(['code'=>CodeMessage::USER_LOGOUT_ERROR]);
        }
    }
}