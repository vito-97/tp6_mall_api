<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 11:45
 */

namespace app\common\exception;


use app\common\CodeMessage;
use think\App;

class ValidateException extends CommonException
{
    protected $errorCode = CodeMessage::VALIDATE_ERROR;
}