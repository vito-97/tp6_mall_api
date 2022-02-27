<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/18
 */

namespace app\common\response;


use app\common\Response;

class Xml extends Response
{
    public function send()
    {
        $data = $this->getData();

        return xml($data);
    }
}