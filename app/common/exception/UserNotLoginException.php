<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/23
 */

namespace app\common\exception;


use app\common\CodeMessage;

class UserNotLoginException extends CommonException
{
    protected $errorCode = CodeMessage::USER_NOT_LOGIN;
}