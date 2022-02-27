<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\logic;


use app\common\CodeMessage;
use app\common\exception\ErrorException;
use app\common\model\mysql\OrderProduct;
use think\helper\Str;

class OrderLogic extends BaseLogic
{
    //用户ID
    protected $uid = 0;
    //数据库查询的商品
    protected $products = [];
    //订单提交的商品
    protected $orderProducts = [];

    /**
     *
     * @param $uid
     * @param int $page
     * @param int $size
     * @return \app\common\model\mysql\BaseModel[]|array|\think\Collection|\think\Paginator
     * @throws \app\common\exception\ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getListByUser($uid, $page = 1, $size = 0)
    {
        $size = $this->getSize($size);

        $args = [
            'where' => [
                'user_id' => $uid,
            ],
            'size'  => $size,
            'page'  => $page
        ];

        return $this->getModel()->getLists($args);
    }

    /**
     * 下单
     * @param $uid
     * @param $products
     * @return \app\common\model\mysql\BaseModel|bool|false
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function place($uid, $products)
    {
        $pid = array_column($products, 'product_id');
        $this->uid = $uid;
        $this->orderProducts = $products;
        $this->setProducts($this->getProductsByID($pid));

        if (empty($this->products)) {
            throw new ErrorException(CodeMessage::PRODUCT_NOT_FOUND);
        }

        $order = $this->getOrderInfo();

        $snapOrder = $this->snapOrder($order);

        $status = $this->createOrderBySnap($snapOrder);

        return $status;
    }

    /**
     * 获取用户的订单信息
     * @param $id
     * @return \app\common\model\mysql\BaseModel|array|mixed|\think\Model|null
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserOrderByID($id)
    {
        $order = $this->getModel()->getByID($id);

        $this->checkOrder($order);

        return $order;
    }

    /**
     * 检查订单
     * @param $order
     * @return bool
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function checkOrder($order)
    {
        if (empty($order)) {
            throw new ErrorException(CodeMessage::ORDER_NOT_FOUND);
        }

        if ($order['user_id'] != $this->getUid()) {
            throw new ErrorException(CodeMessage::ORDER_NOT_FOUND);
        }

        $this->orderNo = $order['order_no'];

        return true;
    }

    /**
     * 获取通过ID获取商品
     * @param $pid
     * @return array
     * @throws \app\common\exception\ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function getProductsByID($pid)
    {
        return (new ProductLogic())->getProductsByID($pid);
    }

    /**
     * 获取订单信息
     * @return array
     * @throws ErrorException
     */
    private function getOrderInfo()
    {
        $products = $this->getOrderProductsInfo();

        $count = array_sum(array_column($products, 'count'));
        $price = array_sum(array_column($products, 'total_price'));

        $order = [
            'count'    => $count,
            'price'    => $price,
            'products' => $products,
        ];

        return $order;
    }

    /**
     * 获取订单中的商品信息
     * @return array
     * @throws ErrorException
     */
    private function getOrderProductsInfo()
    {
        $products = [];

        foreach ($this->orderProducts as $op) {
            if (empty($this->products[$op['product_id']])) {
                throw new ErrorException("ID为{$op['product_id']}的商品不存在，创建订单失败");
            }

            $product = $this->products[$op['product_id']];

            $stockStatus = $product['stock'] >= $op['count'];

            //这里就是对数据库获取的商品进行库存校验，并发大的情况下用redis进行获取库存校验性能比较优
            if (!$stockStatus) {
                $msg = "商品[{$product['name']}]库存不足";
                throw new ErrorException($msg, CodeMessage::PRODUCT_NOT_FOUND);
            }

            $products[] = [
                'id'           => $product['id'],
                'name'         => $product['name'],
                'count'        => $op['count'],
                'price'        => $product['price'],
                'total_price'  => $product['price'] * $op['count'],
                'img'          => $product['main_img_url'],
                'stock_status' => $stockStatus,
            ];
        }

        return $products;
    }

    /**
     * 组装订单快照数据
     * @param $order
     * @return mixed
     */
    private function snapOrder($order)
    {
        $product = $order['products'][0];
        $order['name'] = $product['name'];
        $order['address'] = json_encode($this->getUserAddress());
        $order['img'] = $product['img'];

        if (count($order['products']) > 1) {
            $order['name'] .= '等';
        }

        return $order;
    }

    /**
     * 生成订单
     * @param $snapOrder
     * @return \app\common\model\mysql\BaseModel|bool|false
     * @throws ErrorException
     */
    private function createOrderBySnap($snapOrder)
    {
        $model = $this->getModel();

        $model->transaction(function () use ($snapOrder, $model) {
            $no = $this->makeOrderNo();

            $order = [
                'user_id'      => $this->uid,
                'order_no'     => $no,
                'total_price'  => $snapOrder['price'],
                'total_count'  => $snapOrder['count'],
                'snap_img'     => $snapOrder['img'],
                'snap_name'    => $snapOrder['name'],
                'snap_address' => $snapOrder['address'],
                'snap_items'   => json_encode($snapOrder['products']),
            ];

            $model->save($order);

            foreach ($snapOrder['products'] as $product) {
                $append = [
                    'count' => $product['count'],
                    'price' => $product['price'],
                ];

                $model->products()->attach($product['id'], $append);
            }

            return true;
        });

        return $model;
    }

    protected function makeOrderNo()
    {
        return date('YmdHis') . Str::random(6, 1);
    }

    /**
     * 获取用户地址
     * @return array
     * @throws ErrorException
     */
    protected function getUserAddress()
    {
        $logic = new UserAddressLogic();

        $address = $logic->getAddressByUser($this->uid);

        if (empty($address)) {
            throw new ErrorException(CodeMessage::ADDRESS_EMPTY);
        }

        return $address->toArray();
    }

    /**
     * 通过订单检查商品库存
     * @param $order
     * @return array
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function checkOrderStock($order)
    {
        $orderProduct = OrderProduct::where('order_id', $order['id'])->select()->toArray();
        $pid = array_column($orderProduct, 'product_id');

        $this->orderProducts = $orderProduct;
        $this->setProducts($this->getProductsByID($pid));

        $order = $this->getOrderInfo();

        return $order;
    }

    private function setProducts($products)
    {
        $this->products = array_combine(array_column($products, 'id'), $products);
        return $this;
    }
}