<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/23
 * Time: 9:44
 */

namespace app\api\middleware;


use app\common\logic\UserLogic;

abstract class User
{
    protected $logic;
    protected $token;
    protected $user;

    public function __construct()
    {
        $this->logic = new UserLogic();
    }

    final public function getToken()
    {
        $this->token = $this->logic->getLoginToken();
        return $this->token;
    }

    final public function getUserInfo()
    {
        if ( !$this->user ) {
            $this->user = $this->logic->getLoginUser($this->getToken());
        }

        return $this->user;
    }
}