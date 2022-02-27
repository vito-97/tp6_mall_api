<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\common\logic;


use app\common\CodeMessage;
use app\common\exception\ErrorException;
use think\facade\Log;

class PayLogic extends BaseLogic
{
    protected $orderID;
    protected $orderNo;
    protected $order;

    public function __construct()
    {
        load_wx_pay_sdk();
    }

    /**
     * 拉起支付
     * @param $order_id
     * @return array
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pay($order_id)
    {
        $this->orderID = $order_id;

        if (empty($order_id)) {
            throw new ErrorException(CodeMessage::ORDER_NOT_FOUND);
        }

        $orderLogic = new OrderLogic();

        $order = $this->order = $orderLogic->getUserOrderByID($this->orderID);

        $order = $orderLogic->checkOrderStock($order);

        return $this->makeWxPreOrder($order['price']);
    }

    /**
     * 获取订单
     * @param $order_id
     * @return \app\common\model\mysql\BaseModel|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function getOrder($order_id)
    {
        $logic = new OrderLogic();

        $order = $logic->getByID($order_id);

        return $order;
    }

    /**
     * 构建微信支付订单信息
     * @param $totalPrice
     * @return array
     * @throws ErrorException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function makeWxPreOrder($totalPrice)
    {
        $user = $this->getUser();

        $openid = $user['openid'];

        if (!$openid) {
            throw new ErrorException(CodeMessage::USER_NOT_OPENID);
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNo);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('wx.pay_back_url'));

        return $this->getPaySignature($wxOrderData);
    }

    /**
     * 向微信请求订单号并生成签名
     * @param $wxOrderData
     * @return array
     * @throws \WxPayException
     */
    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        // 失败时不会返回result_code
        if ($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS') {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
            throw new ErrorException(CodeMessage::PAY_ERROR);
        }
        $this->recordPreOrder($wxOrder);
        $sign = $this->sign($wxOrder);
        return $sign;
    }

    private function recordPreOrder($wxOrder)
    {
        // 必须是update，每次用户取消支付后再次对同一订单支付，prepay_id是不同的
        $orderLogic = new OrderLogic();
        $orderLogic->updateByID(['prepay_id' => $wxOrder['prepay_id']], $this->orderID);
    }

    // 签名
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }
}