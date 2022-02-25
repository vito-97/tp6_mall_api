<?php
// +----------------------------------------------------------------------
// | 路由设置
// +----------------------------------------------------------------------

return [
    // 是否强制使用路由
    'url_route_must'        => true,
    // 合并路由规则
    'route_rule_merge'      => true,
    // 路由是否完全匹配
    'route_complete_match'  => true,
    // 是否自动转换URL中的控制器和操作名
    'url_convert'           => false,
    // 是否开启路由延迟解析
    'url_lazy_route'        => true, //必须开，不然分组设置的选项不会在分组里的分组继承到
    //路由中间件
    'middleware'     => [
        \app\api\middleware\Auth::class
    ],
];
