<?php


namespace app\common\validate;


class OrderValidate extends BaseValidate
{
    protected $rule = [
        'products|商品列表'   => 'checkProducts',
        'product_id|商品ID' => 'require|isPositiveInteger',
        'count|购买数量'      => 'require|isPositiveInteger',
    ];

    protected $scene = [
        'place'   => ['products'],
        'product' => ['product_id', 'count'],
    ];

    protected function checkProducts($values)
    {
        if (empty($values)) {
            return ':attribute不能为空';
        }
        foreach ($values as $value) {
            $this->checkProduct($value);
        }
        return true;
    }

    protected function checkProduct($value)
    {
        self::batchCheck($value, 'product');
    }
}