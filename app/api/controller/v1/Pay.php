<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/25
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
use app\common\service\WxNoticeService;
use app\common\validate\IDMustPositiveIntValidate;

class Pay extends Base
{
    public $exceptLogin = ['redirectNotify', 'notifyConcurrency', 'receiveNotify'];

    /**
     * 获取订单信息
     * @url /pay/pre_order
     * @method POST
     * @param int $id 订单id
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function getPreOrder($id = 0)
    {
        IDMustPositiveIntValidate::batchCheck();

        $result = $this->getLogic()->pay($id);

        return $this->success(['data' => $result]);
    }

    public function redirectNotify()
    {
        $notify = new WxNoticeService();
        $notify->Handle();
    }

    public function notifyConcurrency()
    {
        $notify = new WxNoticeService();
        $notify->Handle();
    }

    public function receiveNotify()
    {
        $notify = new WxNoticeService();
        $notify->Handle();
    }
}