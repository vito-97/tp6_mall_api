<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/22
 */

namespace app\api\controller\v1;

use app\api\controller\Base;
use app\common\validate\UserValidate;

class User extends Base
{
    /**
     * 获取当前用户信息
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $user = $this->getUser(true)->hidden(['password']);

        return $this->success(['data' => $user]);
    }

    public function update($id = 0)
    {
        UserValidate::batchCheck(['id' => $this->getUid()], 'update');

        $user = $this->getUser(true);

        $update = $this->request->only(['username', 'nickname', 'sex']);

        $status = $user->save($update);

        if ( $status ) {
            return $this->success(['message' => '修改成功']);
        } else {
            return $this->error(['message' => '修改失败']);
        }
    }
}