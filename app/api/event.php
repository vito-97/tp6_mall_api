<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/21
 */

return [
    'bind'   => [
        'login' => \app\api\event\Login::class,
    ],
    'listen' => [
        'login' => [\app\api\listener\Login::class],
        //支付
        'paying' => [],
    ]
];