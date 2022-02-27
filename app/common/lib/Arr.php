<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/22
 */
declare(strict_types=1);

namespace app\common\lib;


class Arr
{
    /**
     * 获取树形结构
     * @param array $data
     * @param string $pidKey
     * @param string $idKey
     * @return array
     */
    public static function getTree(array $data, string $pidKey = 'pid', string $idKey = 'id'): array
    {
        $tree = [];
        $array = array_combine(array_column($data, $idKey), $data);

        foreach ( $array as $key => $value ) {
            if ( isset($array[$value[$pidKey]]) ) {
                $array[$value[$pidKey]]['list'][] = &$array[$key];
            } else {
                $tree[]              = &$array[$key];
            }
        }

        return $tree;
    }
}