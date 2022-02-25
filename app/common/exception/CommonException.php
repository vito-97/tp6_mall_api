<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 12:10
 */

namespace app\common\exception;


use app\common\CodeMessage;
use think\Exception;
use think\exception\HttpException;
use Throwable;

abstract class CommonException extends Exception
{
    protected $errorCode = 1;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ( is_array($message) ) {
            if ( !empty($message['code']) ) {
                $this->errorCode = $message['code'];
            }
            if ( !empty($message['message']) || !empty($message['msg']) ) {
                $message = $message['message'] ?? $message['msg'];
            }
        } else if ( $code || is_integer($message) ) {
            $this->errorCode = $code ?: $message;
            $message         = CodeMessage::getMessage($this->errorCode);
        }
        parent::__construct($message, 0, $previous);
    }

    public function getStatusCode()
    {
        return $this->errorCode;
    }
}