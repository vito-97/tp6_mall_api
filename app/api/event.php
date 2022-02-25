<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/2/21
 * Time: 14:54
 */

return [
    'bind'   => [
        'login' => \app\api\event\Login::class,
    ],
    'listen' => [
        'login' => [\app\api\listener\Login::class],
    ]
];