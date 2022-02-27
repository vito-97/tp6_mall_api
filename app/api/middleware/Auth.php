<?php
/**
 * Created by PhpStorm.
 * User: Vito
 * Date: 2022/1/23
 */

namespace app\api\middleware;


use app\api\controller\Base;
use app\common\exception\UserNotLoginException;
use think\Container;
use think\exception\ClassNotFoundException;
use think\Request;

class Auth extends User
{
    //排除登录
    public $exceptLogin = [];

    public function handle(Request $request, \Closure $next)
    {
        $module         = app()->http->getName();
        $controller     = str_replace('.', '\\', $request->controller());
        $action         = $request->action();
        $controllerName = config('route.controller_layer');

        $className = "\\app\\$module\\$controllerName\\$controller";
        try {
            /**
             * @var Base $class
             */
            $class = Container::getInstance()->make($className);

        } catch ( ClassNotFoundException $e ) {
            return $next($request);
        }

        //不需要登陆
        if ( !empty($class->noLoginRequired) ) {
            return $next($request);
        }

        //排除的方法
        $except = $this->exceptLogin = $class->exceptLogin;

        if ( in_array($action, $except) ) return $next($request);

        $user = $this->getUserInfo();

        //未登录
        if ( !$user ) {
            throw new UserNotLoginException();
        }

        $request->USER = $user;

        return $next($request);
    }
}