<?php

namespace routers;


class Router{
    public function __invoke(){
        $route=$_GET['route'];
        if (empty($route)){
            $route='page/index';
        }
        $params=[];
        foreach ($_GET as $key=>$value){
            if ($key != 'route'){
                $params[$key]=$value;
            }
        }

        $route=explode('/', $route);
        $controllerName='controllers\\' . ucfirst($route[0]) . 'Controller';
        $method=$route[1];
        if (class_exists($controllerName) && method_exists($controllerName,'action' . ucfirst($method))){
            $controllerInstance=new $controllerName;
            call_user_func_array(array($controllerInstance, 'action' . ucfirst($method)), $params);
        } else {
            http_response_code(404);
        }

    }
}