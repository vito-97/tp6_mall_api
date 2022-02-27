<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
use app\common\validate\IDMustPositiveIntValidate;
use app\common\validate\OrderValidate;
use app\common\validate\PaginateParamsValidate;

class Order extends Base
{
    /**
     * 获取用户订单列表
     * @url /order
     * @method GET
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        PaginateParamsValidate::batchCheck();

        $uid = $this->getUid();

        $result = $this->getLogic()->getListByUser($uid, $this->getPage(), $this->getSize());

        return $this->success(['data' => $result]);
    }

    /**
     * 获取订单信息
     * @url /order/:id
     * @method GET
     * @param int $id 订单ID
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function read($id = 0)
    {
        IDMustPositiveIntValidate::batchCheck();

        $order = $this->getLogic()->getUserOrderByID($id)->hidden(['prepay_id']);

        return $this->success(['data' => $order]);
    }

    /**
     * 提交订单
     * @url /order
     * @method POST
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function place()
    {
        OrderValidate::batchCheck('place');
        $products = $this->request->param('products/a');
        $uid = $this->getUid();

        $order = $this->getLogic()->place($uid, $products);

        $data = [
            'name'     => $order['snap_name'],
            'order_no' => $order['order_no'],
            'order_id' => $order['id'],
            'img'      => $order['snap_img'],
        ];

        return $this->success(['data' => $data]);
    }

    public function delivery()
    {

    }
}