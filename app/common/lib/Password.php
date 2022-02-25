<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 14:15
 */

namespace app\common\lib;


class Password
{
    /**
     * 加密字符串
     * @param $string
     * @param string $salt
     * @return string
     */
    public static function encrypt($string, $salt = 'password')
    {
        $salt = self::getSalt($salt);
        return md5($salt . $string . $salt);
    }

    /**
     * 验证
     * @param $hash
     * @param $string
     * @param string $salt
     * @return bool
     */
    public static function validate($hash, $string, $salt = 'password')
    {
        $hash   = strlen($hash) == 32 ? $hash : self::encrypt($hash, $salt);
        $string = strlen($string) == 32 ? $string : self::encrypt($string, $salt);

        return $hash === $string;
    }

    /**
     * 获取加密盐
     * @param $salt
     * @return mixed
     */
    protected static function getSalt($salt)
    {
        $salt = config('web.salt.' . $salt) ?: $salt;

        return $salt;
    }
}