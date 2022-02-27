<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/24
 */

namespace app\common\model\mysql;


class UserAddress extends BaseModel
{
    protected $hidden =['id', 'delete_time', 'user_id'];
}