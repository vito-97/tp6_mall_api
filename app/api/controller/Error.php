<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/22
 */

namespace app\api\controller;

use app\common\CodeMessage;

class Error extends Base
{
    public $noLoginRequired = true;

    public function __call($method, $args)
    {
        return $this->error(['code' => CodeMessage::NOT_FOUND_CONTROLLER]);
    }

    public function miss(){
        return $this->error(['code' => CodeMessage::NOT_FOUND_ROUTE]);
    }
}