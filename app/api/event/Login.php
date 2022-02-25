<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/23
 * Time: 11:08
 */

namespace app\api\event;


use think\facade\Request;

class Login
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    public function setLoginInfo()
    {
        $user                  = $this->user;
        $user->last_login_time = time();
        $user->last_login_ip   = Request::ip();
        $user->save();

        return true;
    }
}