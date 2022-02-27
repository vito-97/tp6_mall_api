<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
use app\common\CodeMessage;
use app\common\exception\NotExistsException;
use app\common\logic\UserAddressLogic;
use app\common\validate\AddressValidate;
use app\common\validate\ThemeValidate;

class Address extends Base
{
    protected $logic;

    protected function initialize()
    {
        $this->logic = new UserAddressLogic();
    }

    /**
     * 获取收货地址
     * @url /address
     * @medhod GET
     * @return mixed
     * @throws NotExistsException
     * @throws \app\common\exception\ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $uid = $this->getUid();
        $result = $this->logic->getAddressByUser($uid);

        if (empty($result)) {
            throw new NotExistsException(CodeMessage::ADDRESS_EMPTY);
        }

        return $this->success(['data' => $result]);
    }


    /**
     * 保存地址
     * @url /address
     * @method POST
     * @return mixed
     * @throws NotExistsException
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function createOrUpdateAddress()
    {
        AddressValidate::batchCheck();

        $params = AddressValidate::getDataByRule();
        $params['user_id'] = $this->getUid();

        $user = $this->getUser(true);

        $status = $this->logic->createOrUpdateAddress($user, $params);

        if ($status) {
            return $this->success();
        } else {
            return $this->error(['code'=>CodeMessage::ADDRESS_SAVE_ERROR]);
        }
    }
}