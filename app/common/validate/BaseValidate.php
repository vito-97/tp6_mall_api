<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 11:32
 */

namespace app\common\validate;

use app\common\exception\ValidateException;
use think\Container;
use think\facade\Request;
use think\Validate;

abstract class BaseValidate extends Validate
{
    /**
     * 批量验证
     * @param array|string $data
     * @param string $scene
     * @return bool
     * @throws ValidateException
     */
    public static function batchCheck($data = [], $scene = '')
    {
        if ( is_string($data) ) {
            $scene = $data;
            $data  = [];
        }

        $params = Request::param();

        if ( is_array($data) && $data )
            $params = array_merge($params, $data);

        /**
         * @var $class Validate
         */
        $class = Container::getInstance()->invokeClass(static::class);

        $result = $class->batch()->scene($scene)->check($params);

        if ( !$result ) {
            $error = $class->getError();

            $msg = is_array($error) ?
                implode('<br>', $error) : $error;

            $exception = new ValidateException($msg);

            throw $exception;
        } else {
            return true;
        }
    }

    /**
     * 验证是否为不为0的正整数
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if ( is_numeric($value) && is_int($value + 0) && ($value + 0) > 0 ) {
            return true;
        }
        return ':attribute必须是正整数';
    }

    /**
     * 检查传入的id集合
     * @param $value
     * @param $rule
     * @return bool|string
     */
    protected function checkIds($value, $rule)
    {
        $values = explode(',', $value);

        if ( empty($values) ) {
            return ':attribute不能为空';
        }

        foreach ( $values as $id ) {
            if ( true !== $this->isPositiveInteger($id) ) {
                return ':attribute里必须是正整数';
            }
        }

        return true;
    }

    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if ( empty($value) ) {
            return ':attribute不允许为空';
        } else {
            return true;
        }
    }
}