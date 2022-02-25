<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 10:37
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
use app\common\CodeMessage;
use app\common\exception\NotExistsException;
use app\common\logic\ThemeLogic;
use app\common\validate\IDCollectionValidate;
use app\common\validate\IDMustPositiveIntValidate;
use app\common\validate\ThemeValidate;

class Theme extends Base
{
    public $noLoginRequired = true;

    /**
     * 获取主题列表
     * @url /theme?ids=:category_id1,:category_id2,:category_id3...
     * @return mixed
     * @throws NotExistsException
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function index()
    {
        IDCollectionValidate::batchCheck();

        $ids = $this->getIds();

        $result = $this->getLogic()->lists($ids);

        if ( $result->isEmpty() ) {
            throw new NotExistsException(CodeMessage::THEME_NOT_FOUND);
        }

        return $this->success(['data' => $result]);
    }

    /**
     * 获取主题详情
     * @url /theme/:id
     * @param $id
     * @return mixed
     * @throws NotExistsException
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function read($id)
    {
        IDMustPositiveIntValidate::batchCheck();

        $result = $this->getLogic()->getThemeWithProducts($id);

        if ( $result->isEmpty() ) {
            throw new NotExistsException(CodeMessage::THEME_NOT_FOUND);
        }

        return $this->success(['data' => $result]);
    }

    /**
     * 主题关联产品
     * @url /theme/:t_id/product/:p_id
     * @Http POST
     * @param int $t_id 主题id
     * @param int $p_id 商品id
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function createThemeProduct($t_id, $p_id)
    {
        ThemeValidate::batchCheck(__FUNCTION__);

        $status = $this->getLogic()->createThemeProduct($t_id, $p_id);

        if ( $status ) {
            return $this->success(['msg' => '添加成功']);
        } else {
            return $this->error(['code' => CodeMessage::THEME_ADD_PRODUCT_ERROR]);
        }
    }

    /**
     * 主题删除关联产品
     * @url /theme/:t_id/product/:p_id
     * @Http DELETE
     * @param int $t_id 主题id
     * @param int $p_id 商品id
     * @return mixed
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function deleteThemeProduct($t_id, $p_id)
    {
        ThemeValidate::batchCheck(__FUNCTION__);

        $status = $this->getLogic()->deleteThemeProduct($t_id, $p_id);

        if ( $status ) {
            return $this->success(['msg' => '删除成功']);
        } else {
            return $this->error(['code' => CodeMessage::THEME_ADD_PRODUCT_ERROR]);
        }
    }
}