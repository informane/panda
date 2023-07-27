<?php

namespace controllers;

class Controller{
    protected $title;

    protected function render($view, $params=[]){
        $view=$view . '.php';
        $title=$this->title;
        require_once("../views/layout.php");
    }

    protected function redirect($url){
        header("Location: $url");
    }

    protected function beforeAction(){
        session_start();
    }

    public function __call($method, $args){
        if ($method != 'beforeAction' && $method != 'render' && $method != 'redirect'){
            $this->beforeAction();
        }
        if (method_exists($this, $method)){
            return call_user_func_array(array($this, $method), $args);
        }
    }
}