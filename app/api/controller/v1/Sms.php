<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 10:52
 */

namespace app\api\controller\v1;

use app\common\CodeMessage;
use app\common\logic\SmsLogic;
use app\common\validate\SmsValidate;
use app\api\controller\Base;

class Sms extends Base
{
    public $exceptLogin = ['send'];

    /**
     * 发送短信
     * @param string $phone
     * @param string $scene
     * @return mixed
     * @throws \app\common\exception\ValidateException
     */
    public function send($phone = '', $scene = 'validate')
    {
        $smsLogic = new SmsLogic();
        //验证器
        SmsValidate::batchCheck();

        $code = rand(1000, 9999);

        $status = $smsLogic->send($phone, $code, $scene);

        if ( $status ) {
            return success(['message' => '发送短信成功']);
        } else {
            return error(['code' => CodeMessage::SEND_SMS_ERROR]);
        }
    }
}