<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/18
 * Time: 17:16
 */

namespace app\common;


class CodeMessage
{
    const SUCCESS = 0;
    const ERROR = 1;

    const USER_NOT_FOUND = 1001;
    const LOGIN_ERROR = 1002;
    const USER_DISABLED = 1003;
    const USER_PHONE_LOGIN_ERROR = 1004;
    const USER_REGISTER_ERROR = 1005;
    const USER_LOGOUT_ERROR = 1006;
    const USER_NOT_LOGIN = 1100;

    const SEND_SMS_ERROR = 2001;
    const SMS_VALIDATE_ERROR = 2002;

    const THEME_NOT_FOUND = 3001;
    const THEME_ADD_PRODUCT_ERROR = 3002;
    const THEME_DELETE_PRODUCT_ERROR = 3003;

    const PRODUCT_NOT_FOUND = 4001;

    const CATEGORY_EMPTY = 5001;

    const VALIDATE_ERROR = 9001;
    const NOT_EXISTS_ERROR = 9002;
    const NOT_FOUND_CONTROLLER = 9003;
    const NOT_FOUND_ACTION = 9004;
    const NOT_FOUND_ROUTE = 9005;
    const SERVICE_ERROR = 9999;

    /**
     * 错误码对应的错误信息
     * @var array
     */
    protected static $message = [
        self::SUCCESS => 'success',
        self::ERROR   => 'error',

        self::USER_NOT_FOUND         => '账号或密码错误',
        self::LOGIN_ERROR            => '账号或密码错误',
        self::USER_DISABLED          => '账号已被禁用',
        self::USER_PHONE_LOGIN_ERROR => '手机登录失败',
        self::USER_REGISTER_ERROR    => '注册失败',
        self::USER_NOT_LOGIN         => '未登录',
        self::USER_LOGOUT_ERROR      => '登出失败',

        self::SEND_SMS_ERROR     => '发送短信失败',
        self::SMS_VALIDATE_ERROR => '验证码错误',

        self::THEME_NOT_FOUND            => '指定主题不存在，请检查主题ID',
        self::THEME_ADD_PRODUCT_ERROR    => '主题添加商品失败',
        self::THEME_DELETE_PRODUCT_ERROR => '删除主题商品失败',

        self::PRODUCT_NOT_FOUND => '商品不存在',

        self::CATEGORY_EMPTY => '未定义分类',

        self::VALIDATE_ERROR       => '数据验证失败',
        self::NOT_EXISTS_ERROR     => '数据不存在',
        self::NOT_FOUND_CONTROLLER => '找不到控制器',
        self::NOT_FOUND_ACTION     => '没有指定方法',
        self::NOT_FOUND_ROUTE      => '未定义路由',
        self::SERVICE_ERROR        => '服务器发生内部错误，请稍后重试',
    ];

    /**
     * 设置信息
     * @param $code
     * @param string $message
     */
    public static function setMessage($code, $message = '')
    {
        if ( is_array($code) ) {
            self::$message = array_merge(self::$message, $code);
        } else {
            self::$message[$code] = $message;
        }
    }

    /**
     * 获取信息
     * @param $code
     * @return mixed|string
     */
    public static function getMessage($code)
    {
        return self::$message[$code] ?? 'error';
    }
}