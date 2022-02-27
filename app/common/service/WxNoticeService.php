<?php


namespace app\common\service;

use app\common\CodeMessage;
use app\common\exception\ErrorException;
use app\common\logic\OrderLogic;
use app\common\model\mysql\Order;
use app\common\model\mysql\Product;
use think\facade\Db;
use think\facade\Event;
use think\facade\Log;

load_wx_pay_sdk();

class WxNoticeService extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $orderNo = $data['out_trade_no'];
            Db::startTrans();
            $order = Order::where('order_no', $orderNo)->lock(true)->find();
            try {
                if ($order->status == Order::STATUS_UNPAID) {
                    $orderLogic = new OrderLogic();

                    $status = $orderLogic->checkOrderStock($order);
                    if ($status) {
                        $this->updateOrderStatus($order->id, true);
                        $this->reduceStock($status);
                    }
                    Event::trigger('paying', $order);
                }
                Db::commit();
            } catch (ErrorException $e) {
                Log::error($e);
                $this->updateOrderStatus($order->id, false);
                return false;
            } catch (\Exception $ex) {
                Db::rollback();
                Log::error($ex);
                // 如果出现异常，向微信返回false，请求重新发送通知
                return false;
            }
        }
        return true;
    }


    private function reduceStock($status)
    {
        $status = true;
        $errorMsg = [];
        foreach ($status['products'] as $product) {
            $s = Product::where('id', $product['product_id'])
                ->where('stock', '>', 0)
                ->dec('stock', $product['count']);

            if (!$s) {
                $errorMsg[] = "商品[{$product['name']}]库存量不足，更新失败";
            }
        }

        if ($errorMsg) {
            throw new ErrorException($errorMsg, CodeMessage::PRODUCT_NOT_STOCK);
        }
    }

    private function updateOrderStatus($orderID, $success)
    {
        $status = $success ? Order::STATUS_PAID : Order::STATUS_PAID_BUT_OUT_OF;
        Order::where('id', $orderID)
            ->update(['status' => $status]);
    }
}