<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/22
 * Time: 15:08
 */

namespace app\common\traits;


use app\common\exception\ErrorException;
use app\common\logic\BaseLogic;

trait AppTrait
{
    /**
     * @var BaseLogic
     */
    protected $logic;

    /**
     * 设置逻辑操作类
     * @param $class
     * @return $this
     */
    protected function setLogic($class)
    {
        if ( is_string($class) ) {
            $this->logic = new $class;
        } elseif ( is_object($class) && $class instanceof BaseLogic ) {
            $this->logic = $class;
        }

        return $this;
    }

    /**
     * 获取逻辑操作类
     * @return BaseLogic
     * @throws ErrorException
     */
    protected function getLogic()
    {
        if ( $this->logic ) {
            return $this->logic;
        }

        $class = static::class;

        $module = app('http')->getName();

        $name = basename($class);

        $className = "app\\{$module}\\logic\\{$name}Logic";

        if ( $module && class_exists($className) ) {
            $this->logic = new $className;
            return $this->logic;
        }

        $className = "app\\common\\logic\\{$name}Logic";

        if ( class_exists($className) ) {
            $this->logic = new $className;
            return $this->logic;
        }

        throw new ErrorException('请定义逻辑操作类');
    }

    /**
     * 获取加载数量
     * @param int $default
     * @return int|mixed
     */
    public function getSize($default = 20)
    {
        $size = $this->request->param('size', $default, 'intval');

        if ( $size <= 0 ) {
            $size = $default;
        }

        if ( $size > 100 ) {
            $size = 100;
        }
        return $size;
    }

    /**
     * 成功响应
     * @param array $args
     * @return mixed
     */
    protected function success($args = [])
    {
        return success($args, $this->getCurrentResponseType());
    }

    /**
     * 失败响应
     * @param array $args
     * @return mixed
     */
    protected function error($args = [])
    {
        return error($args, $this->getCurrentResponseType());
    }

    /**
     * 获取当前响应类型
     * @return string
     */
    protected function getCurrentResponseType()
    {
        static $type;

        if ( empty($type) ) {
            $types = $this->getResponseTypes();

            $key     = config('web.api_response_key');
            $default = config('web.api_default_response');

            if ( !in_array($default, $types) ) {
                $type = 'json';
            }

            $type = $this->request->param($key, $default, 'strtolower');

            if ( !in_array($type, $types) ) {
                $type = $default;
            }
        }

        return $type;
    }

    /**
     * 获取所有响应的类型
     * @return array
     */
    protected function getResponseTypes()
    {
        static $types;

        if ( empty($types) ) {
            $path = base_path() . '/commom/response/*.php';

            $types = array_map(
                function($file) {
                    return strtolower(substr(basename($file), 0, -3));
                },
                glob($path)
            );
        }

        return $types;
    }
}