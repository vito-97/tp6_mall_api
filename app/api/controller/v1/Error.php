<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/22
 * Time: 15:43
 */

namespace app\api\controller\v1;

use app\api\controller\Base;
use app\common\CodeMessage;

class Error extends Base
{
    public $noLoginRequired = true;

    public function __call($method, $args)
    {
        return $this->error(['code' => CodeMessage::NOT_FOUND_CONTROLLER]);
    }
}