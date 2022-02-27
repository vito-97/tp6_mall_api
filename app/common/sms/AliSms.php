<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

namespace app\common\sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class AliSms extends SmsHandle
{
    protected $message = '';

    public function init()
    {
        try {
            $config = $this->config;
            AlibabaCloud::accessKeyClient($config['key'], $config['secret'])
                ->regionId($config['region'])
                ->asDefaultClient();
        } catch ( \Exception $exception ) {
            $this->message = $exception->getMessage();
        }

    }

    /**
     * 发送短信验证码
     * @param $phone
     * @param $code
     * @param string $scene
     * @return bool
     */
    public function sendCode($phone, $code, $scene = 'validate')
    {
        try {
            $config = $this->config;
            AlibabaCloud::accessKeyClient($config['key'], $config['secret'])
                ->regionId($config['region'])
                ->asDefaultClient();
            // 发送请求
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version($config['version'])
                ->action('SendSms')
                ->method('POST')
                ->options([
                              'query' => [
                                  'RegionId'      => $config['region'],
                                  //需要发送到那个手机
                                  'PhoneNumbers'  => $phone,
                                  //必填项 签名(需要在阿里云短信服务后台申请)
                                  'SignName'      => $config['name'],
                                  //必填项 短信模板code (需要在阿里云短信服务后台申请)
                                  'TemplateCode'  => $config['template_id'][$scene],
                                  //如果在短信中添加了${code} 变量则此项必填 要求为JSON格式
                                  'TemplateParam' => json_encode(['code' => $code]),
                              ],
                          ])
                ->request();

            $result = $result->toArray();

            if ( isset($result['code']) && $result['code'] === 'OK' ) {
                return true;
            } else {
                return false;
            }

        } catch ( ServerException $exception ) {
            $this->message = $exception->getMessage();
            return false;
        } catch ( ClientException $exception ) {
            $this->message = $exception->getMessage();
            return false;
        }
    }
}