<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 10:28
 */

return [
    'type'      => 'ali',
    'cache_key' => 'send_phone_code_error_{scene}_{phone}',
    'expire'    => 600,
    'scene'     => ['validate', 'login', 'register'],

    'ali' => [
        'name'        => '维多商城',
        'key'         => 'xxx',
        'secret'      => 'xxx',
        'region'      => 'cn-hangzhou',
        'version'     => '2017-05-25',
        'template_id' => [
            'validate' => 'xxx',
            'login'    => 'xxx',
            'register' => 'xxx',
        ],
    ],
];
