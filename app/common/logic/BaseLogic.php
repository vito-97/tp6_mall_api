<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/18
 * Time: 16:15
 */

namespace app\common\logic;


use app\common\model\mysql\BaseModel;
use think\facade\Cache;
use think\Model;

abstract class BaseLogic
{
    //模型
    protected $model;

    //缓存驱动类型
    protected $cacheStore = 'file';

    protected $defaultSize = 30;

    public function __construct()
    {
//        $this->getModel();

    }

    /**
     * 获取缓存类
     * @param string $type
     * @return Cache
     */
    public function getCache($type = null)
    {
        static $drive = [];

        if ( !$type ) {
            $type = $this->cacheStore;
        }

        if ( empty($drive[$type]) ) {
            $drive[$type] = Cache::store($type);
        }

        return $drive[$type];
    }

    /**
     * 通过ID获取数据
     * @param $id
     * @param array $args
     * @return BaseModel|array|mixed|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByID($id, $args = [])
    {
        return $this->getModel()->getByID($id, $args);
    }

    /**
     * 获取一条数据
     * @param $field
     * @param null $value
     * @return BaseModel|array|mixed|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getOne($field, $value = null)
    {
        if ( is_array($field) )
            $where = $field;
        else
            $where = [$field => $value];

        return $this->getModel()->where($where)->find();
    }

    /**
     * 更新内容
     * @param $data
     * @param $id
     * @return bool
     */
    public function updateByID($data, $id)
    {
        return $this->getModel()->updateByID($data, $id);
    }

    /**
     * 新增数据
     * @param $data
     * @return BaseModel|bool|false
     */
    public function create($data)
    {
        $model = $this->getModel();

        $status = $model->save($data);

        return $status ? $model : false;
    }

    /**
     * 新增或修改
     * @param $data
     * @param int $id
     * @return BaseModel|bool|false
     */
    public function save($data, $id = 0)
    {
        if ( $id ) {
            return $this->updateByID($data, $id);
        } else {
            return $this->create($data);
        }
    }

    /**
     * 通过ID删除
     * @param $id
     * @return bool
     */
    public function deleteByID($id)
    {
        return $this->getModel()->deleteByID($id);
    }

    /**
     * @return false|BaseModel
     */
    public function getModel($new = false)
    {

        if ( $this->model && !$new ) {
            return $this->model;
        }

        $class = static::class;

        $module = app('http')->getName();

        $name = substr(basename($class), 0, -5);

        $className = "app\\{$module}\\model\\mysql\\{$name}";

        if ( $module && class_exists($className) ) {
            $this->model = new $className;
            return $this->model;
        }

        $className = "app\\common\\model\\mysql\\{$name}";

        if ( class_exists($className) ) {
            $this->model = new $className;
            return $this->model;
        }

        return false;
    }

    /**
     * 设置模型
     * @param $class
     * @return $this
     */
    public function setModel($class)
    {
        if ( is_string($class) ) {
            $this->model = new $class;
        } elseif ( is_object($class) && $class instanceof Model ) {
            $this->model = $class;
        }

        return $this;
    }

    protected function getSize($size = 0)
    {
        return $size ?? $this->defaultSize;
    }
}