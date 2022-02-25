<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/25
 * Time: 9:55
 */

namespace app\api\controller\v1;


use app\api\controller\Base;
use app\common\exception\NotExistsException;
use app\common\validate\IDMustPositiveIntValidate;

class Banner extends Base
{
    public $noLoginRequired = true;

    /**
     * 获取banner信息
     * @url /banner/:id
     * @param int $id banner id
     * @return mixed
     * @throws NotExistsException
     * @throws \app\common\exception\ErrorException
     * @throws \app\common\exception\ValidateException
     */
    public function read($id)
    {
        IDMustPositiveIntValidate::batchCheck();

        $logic = $this->getLogic();

        $banner = $logic->getBannerById($id);

        if ( empty($banner) ) {
            throw new NotExistsException(['msg' => '请求banner不存在']);
        }

        return $this->success(['data' => $banner]);
    }
}