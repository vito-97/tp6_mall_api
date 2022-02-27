<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/18
 */

namespace app\common\model\mysql;


use think\Model;
use think\model\concern\SoftDelete;

abstract class BaseModel extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    //软删除
    use SoftDelete;

    protected $hidden = ['delete_time'];

    //设置删除字段的默认值
    protected $defaultSoftDelete = 0;

    protected $autoWriteTimestamp = true;

    /**
     * 获取数据列表
     * @param array $args 参数
     * @param bool $paginate 是否需要分页
     * @return BaseModel[]|array|\think\Collection|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getLists($args = [], $paginate = true)
    {
        $default = [
            'where'    => null,
            'where_or' => null,
            'with'     => null,
            'scope'    => null,
            'order'    => null,
            'size'     => 30,
            'page'     => 1,
            'limit'    => null,
            'field'    => '*',
            'query'    => [],
        ];

        $args = array_merge($default, $args);

        $paginate = false === $args['page'] ? false : $paginate;

        $query = $this->field($args['field'])->where($args['where'])
            ->whereOr($args['where_or'])
            ->with($args['with'])
            ->order($args['order']);

        if ( $args['scope'] ) {
            $query = $query->scope($args['scope']);
        }

        //需要调用query去回调查询
        if ( is_array($args['query']) ) {
            foreach ( $args['query'] as $queryFn ) {
                if ( is_callable($queryFn) ) {
                    call_user_func_array($queryFn, [$query]);
                }
            }
        }

        //需要分页
        if ( $paginate ) {
            $config = [
                'list_rows' => $args['size'],
                'page'      => $args['page']
            ];
            return $query->paginate($config);
        } else {
            if ( $args['limit'] ) {
                $query = $query->limit($args['limit']);
            }
            return $query->select();
        }
    }

    /**
     * 通过ID获取
     * @param $id
     * @param array $args
     * @return BaseModel|array|mixed|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByID($id, $args = [])
    {
        $query = $this;

        //条件
        if ( !empty($args['where']) ) {
            $query = $query->where($args['where']);
        }

        //查询范围
        if ( !empty($args['scope']) ) {
            $query = $query->scope($args['scope']);
        }

        //关联
        if ( !empty($args['with']) ) {
            $query = $query->with($args['with']);
        }

        return $query->find($id);
    }

    /**
     * 更新
     * @param $data
     * @param $id
     * @return bool
     */
    public function updateByID($data, $id)
    {
        $obj = $this->getByID($id);

        if ( !$obj || !$obj->exists() ) {
            return false;
        }

        $status = $obj->save($data);

        return $status ? $obj : false;
    }

    /**
     * 通过ID删除
     * @param $id
     * @return bool
     */
    public function deleteByID($id)
    {
        $obj = $this->getByID($id);

        if ( !$obj || !$obj->exists() ) {
            return false;
        }

        return $obj->delete();
    }

    /**
     * 排序条件
     * @param $query
     */
    public function scopeSort($query)
    {
        $query->order(['sort' => 'desc', 'id' => 'desc']);
    }

    /**
     * 获取正常状态
     * @param $query
     * @param $status
     */
    public function scopeStatus($query, $status = self::STATUS_ON)
    {
        $query->where('status', $status);
    }

    protected function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if ( $data['from'] == 1 ) {
            $finalUrl = config('web.img_host') . $value;
        }
        return $finalUrl;
    }
}