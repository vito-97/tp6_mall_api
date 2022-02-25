<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 16:10
 */

namespace app\common\lib;


use app\common\exception\ErrorException;
use think\facade\Log;

class WeiXin
{
    protected $appID;
    protected $appSecret;
    protected $loginUrl;

    public function __construct()
    {
        $this->appID     = config('wx.app_id');
        $this->appSecret = config('wx.app_secret');
    }

    /**
     * 获取用户信息
     * @param $code
     * @return mixed
     * @throws ErrorException
     */
    public function getUserInfo($code)
    {
        $url = sprintf(
            config('wx.login_url'), $this->appID, $this->appSecret, $code);

        $result = curl_get($url);

        $result = json_decode($result, true);

        if ( empty($result) ) {
            Log::info('wx get user info err:' . $result);
            throw new ErrorException('获取session_key及openID时异常');
        }

        if ( isset($result['errcode']) ) {
            throw new ErrorException(['msg' => $result['errmsg'], 'code' => $result['errcode']]);
        }

        return $result;

    }
}