<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/23
 * Time: 10:57
 */

namespace app\common\exception;


use app\common\CodeMessage;

class UserNotLoginException extends CommonException
{
    protected $errorCode = CodeMessage::USER_NOT_LOGIN;
}