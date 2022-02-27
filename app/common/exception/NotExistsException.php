<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

namespace app\common\exception;


use app\common\CodeMessage;

class NotExistsException extends CommonException
{
    protected $errorCode = CodeMessage::NOT_EXISTS_ERROR;
}