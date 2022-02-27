<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\logic;


use app\common\model\mysql\User;

class UserAddressLogic extends BaseLogic
{
    public function getAddressByUser($uid)
    {
        return $this->getOne('user_id', $uid);
    }

    /**
     * 新增或修改地址
     * @param User $user
     * @param $data
     * @return mixed
     */
    public function createOrUpdateAddress($user, $data)
    {
        $address = $user->address;

        if ($address) {
            return $address->save($data);
        } else {
            return $user->address()->save($data);
        }
    }
}