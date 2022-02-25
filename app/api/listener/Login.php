<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/23
 * Time: 11:09
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