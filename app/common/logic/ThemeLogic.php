<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 10:51
 */

namespace app\common\logic;


use app\common\CodeMessage;
use app\common\exception\NotExistsException;
use app\common\model\mysql\Product;
use app\common\model\mysql\Theme;
use think\model\Pivot;

class ThemeLogic extends BaseLogic
{
    /**
     * 获取指定ID的主题列表
     * @param array $ids
     * @return \app\common\model\mysql\BaseModel[]|array|false[]|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lists($ids = [])
    {
        $model = $this->getModel();

        $result = $model->with(['topic_img', 'head_img'])->select($ids);

        return $result;
    }

    /**
     * 获取主题并关联产品
     * @param $id
     * @return \app\common\model\mysql\BaseModel|array|false|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getThemeWithProducts($id)
    {
        $args = ['with' => ['products', 'topic_img', 'head_img']];

        $themes = $this->getByID($id, $args);

        return $themes;
    }

    /**
     * 新增中间表关系
     * @param $themeID
     * @param $productID
     * @return mixed
     * @throws NotExistsException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function createThemeProduct($themeID, $productID)
    {
        ['theme' => $theme, 'product' => $product] = $this->checkRelationExists($themeID, $productID);

        //单独更新中间表数据 以下两种方式都可
//        return $theme->products()->attach($productID);
        return $theme->products()->save($product);
    }

    /**
     * 删除主题中间表数据
     * @param $themeID
     * @param $productID
     * @return mixed
     * @throws NotExistsException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function deleteThemeProduct($themeID, $productID){
        ['theme' => $theme, 'product' => $product] = $this->checkRelationExists($themeID, $productID);

        return $theme->products()->detach($productID);
    }

    /**
     * 检查主题和商品是否存在
     * @param $themeID
     * @param $productID
     * @return array
     * @throws NotExistsException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function checkRelationExists($themeID, $productID)
    {
        $theme = Theme::find($themeID);
        if ( !$theme ) {
            throw new NotExistsException(CodeMessage::THEME_NOT_FOUND);
        }

        $product = Product::find($productID);
        if ( !$product ) {
            throw new NotExistsException(CodeMessage::PRODUCT_NOT_FOUND);
        }

        return [
            'theme'   => $theme,
            'product' => $product
        ];
    }
}