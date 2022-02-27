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
use app\common\validate\IDMustPositiveIntValidate;
use app\common\validate\PaginateParamsValidate;

class Product extends Base
{
    public $noLoginRequired = true;

    /**
     * 获取指定分类下的商品
     * @url /product?id=:category_id&page=:page&size=:size
     * @param int $id
     * @return mixed
     * @throws \app\common\exception\ErrorException
     */
    public function index($id = 0)
    {
        //验证器
        batch_check(IDMustPositiveIntValidate::class, PaginateParamsValidate::class);

        $logic = $this->getLogic();

        $result = $logic->getProductsByCategoryID($id, $this->getPage(), $this->getSize());

        return $this->success(['data' => $result]);
    }

    /**
     * 获取指定分类下的所有商品
     * @url /product/all?id=:category_id
     * @param int $id
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function all($id = 0)
    {
        IDMustPositiveIntValidate::batchCheck();

        $logic = $this->getLogic();

        $result = $logic->getProductsByCategoryID($id, false);

        return $this->success(['data' => $result]);
    }

    /**
     * 获取指定数量的最近商品
     * @url /product/recent?size=:size
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function recent()
    {
        PaginateParamsValidate::batchCheck('size');

        $logic = $this->getLogic();

        $result = $logic->getMostRecent();

        return $this->success(['data' => $result]);
    }

    /**
     * 获取商品详情
     * @param int $id
     * @url /product/<id>
     * @return mixed
     * @throws NotExistsException
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function read($id = 0)
    {
        IDMustPositiveIntValidate::batchCheck();

        $logic = $this->getLogic();

        $result = $logic->getProductDetail($id);

        if ( empty($result) ) {
            throw new NotExistsException(CodeMessage::PRODUCT_NOT_FOUND);
        }

        return $this->success(['data' => $result]);
    }

    public function create()
    {
        //todo
    }

    public function delete($id)
    {
        IDMustPositiveIntValidate::batchCheck();

        //todo
    }

}