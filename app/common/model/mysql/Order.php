<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/24
 */

namespace app\common\model\mysql;


class Order extends BaseModel
{
    // 待支付
    const STATUS_UNPAID = 1;

    // 已支付
    const STATUS_PAID = 2;

    // 已发货
    const STATUS_DELIVERED = 3;

    // 已支付，但库存不足
    const STATUS_PAID_BUT_OUT_OF = 4;

    // 已处理PAID_BUT_OUT_OF
    const STATUS_HANDLED_OUT_OF = 5;

    const STATUS_DESC = [
        self::STATUS_UNPAID          => '待支付',
        self::STATUS_PAID            => '已支付',
        self::STATUS_DELIVERED       => '已发货',
        self::STATUS_PAID_BUT_OUT_OF => '库存不足',
        self::STATUS_HANDLED_OUT_OF  => '已处理',
    ];

    public function products(){
        return $this->belongsToMany('Product','OrderProduct','product_id','order_id');
    }

    public function getSnapItemsAttr($value)
    {
        if(empty($value)){
            return [];
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        if(empty($value)){
            return [];
        }
        return json_decode(($value));
    }
}