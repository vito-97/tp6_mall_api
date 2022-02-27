<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

namespace app\common\sms;


abstract class SmsHandle
{
    protected $message = '';

    protected $config = [];

    /**
     * 初始化获取配置
     * SmsHandle constructor.
     */
    public function __construct()
    {
        $class        = static::class;
        $type         = strtolower(substr(basename($class), 0, -3));
        $this->config = config('sms.' . $type);
        $this->init();
    }

    //初始化
    protected function init()
    {
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 发送短信验证码
     * @param $phone
     * @param $code
     * @param string $scenc
     * @return bool
     */
    abstract public function sendCode($phone, $code, $scene = 'validate');
}