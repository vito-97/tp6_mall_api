<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/18
 * Time: 16:19
 */

namespace app\common;


use think\Container;

abstract class Response
{
    //状态
    protected $status = true;
    //错误码
    protected $code = 0;
    //信息
    protected $message = 'success';
    //数据
    protected $data = [];

    /**
     * 设置属性值
     * Response constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        foreach ( $data as $key => $value ) {
            if ( in_array($key, ['status', 'code', 'message', 'data']) && isset($this->$key) ) {
                $this->$key = $value;
            }
        }

        $this->setMessage();
    }

    /**
     * 创建工厂模式
     * @param array $data
     * @param string $type
     * @return mixed
     */
    public static function create($data = [], $type = 'json')
    {
        $class = false !== strpos($type, '\\') ? $type : '\\app\\common\\response\\' . ucfirst(strtolower($type));

        return Container::getInstance()->invokeClass($class, [$data]);
    }

    /**
     * 设置成功信息
     * @param string $message
     * @param array $data
     * @return array
     */
    final public function success($message = 'success', $data = [])
    {
        $this->setData(true, 0, $message, $data);

        return $this->send();
    }

    /**
     * 设置错误信息
     * @param string $message
     * @param int $code
     * @param array $data
     * @return array
     */
    final public function error($message = 'error', $code = 1, $data = [])
    {
        $this->setData(false, $code, $message, $data);

        return $this->send();
    }

    /**
     * 设置数据
     * @param bool $status
     * @param int $error_code
     * @param string $message
     * @param array $data
     * @return $this
     */
    public function setData($status = true, $code = 0, $message = 'success', $data = [])
    {
        $this->status  = $status;
        $this->code    = $code;
        $this->message = $message;
        $this->data    = $data;

        $this->setMessage();

        return $this;
    }

    /**
     * 获取数据集合
     * @return array
     */
    public function send()
    {
        return $this->getData();
    }

    /**
     * 获取数据
     * @return array
     */
    public function getData()
    {
        return [
            'status'  => $this->status,
            'code'    => $this->code,
            'message' => $this->message,
            'data'    => $this->data,
        ];
    }

    /**
     * 设置消息
     * @return $this
     */
    protected function setMessage()
    {
        if ( isset($this->code) && in_array($this->message, ['success', 'error']) ) {
            $message = CodeMessage::getMessage($this->code);

            $this->message = $message;
        }

        return $this;
    }
}