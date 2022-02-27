<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/18
 */

namespace app\common\response;


use app\common\Response;

class Json extends Response
{
    /**
     * 发送JSON数据
     * @return array|\think\response\Json
     */
    public function send()
    {
        $data = $this->getData();
        return json($data);
    }
}