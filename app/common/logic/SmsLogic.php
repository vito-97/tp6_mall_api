<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 10:56
 */

namespace app\common\logic;


use app\common\sms\SmsHandle;
use think\Container;
use think\facade\Cache;
use think\facade\Log;

class SmsLogic extends BaseLogic
{
    protected $cacheKey = 'send_phone_code_{scene}_{phone}';

    protected $code = '';

    protected $phone = '';

    protected $scene = '';

    protected $cacheStore = 'redis';

    protected $cache;

    public function __construct($phone = '', $scene = '', $code = '')
    {
        $this->phone = $phone;
        $this->scene = $scene;
        $this->code  = $code;

        $this->cache = $this->getCache();
    }

    /**
     * 发送短信验证码
     * @param $phone
     * @param $code
     * @param string $scene
     * @return mixed
     */
    public function send($phone, $code, $scene = 'validate')
    {
        $type = ucfirst(config('sms.type'));

        $className = "\app\common\sms\\{$type}Sms";

        /**
         * @var $class SmsHandle
         */
        $class = Container::getInstance()->invokeClass($className);

        if ( config('web.is_local') && config('web.sms_test') ) {
            $status  = true;
            $date    = date('Y-m-d H:i:s');
            $logFile = root_path() . '/sms_log.txt';
            file_put_contents($logFile, "[{$date}]发送场景{$scene} 手机号{$phone} 验证码[{$code}]\r\n", FILE_APPEND);
        } else {
            $status = $class->sendCode($phone, $code, $scene);
        }

        if ( $status ) {
            $this->setCode($phone, $code, $scene);
        } else {
            //记录信息
            Log::info($this->getCacheKey($phone, $scene) . '：' . $class->getMessage());
        }

        return $status;
    }

    /**
     * 验证code是否正确
     * @param $phone
     * @param $code
     * @param string $scene
     * @return bool
     */
    public function validate($phone, $code, $scene = 'validate')
    {
        $c = $this->getCode($phone, $scene);

        return $code == $c;
    }

    /**
     * 删除缓存
     * @param $phone
     * @param string $scene
     * @return bool
     */
    public function deleteCode($phone, $scene = 'validate')
    {
        $key = $this->getCacheKey($phone, $scene);

        return $this->cache->delete($key);
    }

    /**
     * 获取缓存key
     * @param $phone
     * @param string $scene
     * @return string
     */
    public function getCacheKey($phone, $scene = 'validate')
    {
        $key = str_replace(['{phone}', '{scene}'], [$phone, $scene], config('sms.cache_key') ?: $this->cacheKey);

        return $key;
    }

    /**
     * 设置验证码
     * @param $phone
     * @param $code
     * @param string $scene
     * @return bool
     */
    public function setCode($phone, $code, $scene = 'validate')
    {
        $key = $this->getCacheKey($phone, $scene);

        return $this->cache->set($key, $code, config('sms.expire'));
    }

    /**
     * 获取验证码
     * @param $phone
     * @param string $scene
     * @return mixed
     */
    public function getCode($phone, $scene = 'validate')
    {
        $key = $this->getCacheKey($phone, $scene);

        return $this->cache->get($key);
    }
}