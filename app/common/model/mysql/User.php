<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/22
 */

namespace app\common\model\mysql;


class User extends BaseModel
{
    public function orders()
    {
        return $this->hasMany('Order', 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }
}