<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/23
 */

namespace app\api\listener;


class Login
{
    public function handle($event)
    {
        $event->setLoginInfo();

        return true;
    }
}