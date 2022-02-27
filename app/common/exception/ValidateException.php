<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

namespace app\common\exception;


use app\common\CodeMessage;
use think\App;

class ValidateException extends CommonException
{
    protected $errorCode = CodeMessage::VALIDATE_ERROR;
}