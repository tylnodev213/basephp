<?php
class App{

    protected $controller="UserController";
    protected $action="login";
    protected $params=[];
    protected $object;

    function __construct(){
        
        $arr = $this->UrlProcess();
        // Controller
        if( file_exists("./mvc/controllers/".$arr[0]."Controller.php") ){
            $this->controller = $arr[0]."Controller";
            $this->object=$arr[0];
            unset($arr[0]);
        }
        require_once "./mvc/controllers/". $this->controller .".php";
        $this->controller = new $this->controller;

        // Action
        if(isset($arr[1])){
            $arr[1]=str_replace(strchr($arr[1],"?"),"",$arr[1]);
            if( method_exists( $this->controller , $arr[1]) ){
                $this->action = $arr[1];
            }
            unset($arr[1]);
        }

        // Params
        $this->params = $arr?array_values($arr):[];

        call_user_func_array([$this->controller, $this->action], $this->params );

    }

    function UrlProcess(){
        if( isset($_SERVER['REQUEST_URI']) ){
            $url = str_replace("/basephp", "", $_SERVER['REQUEST_URI']);
            return explode("/", filter_var(trim($url, "/")));
        }
    }
    function getAction(){
        return $this->action;
    }
    function getController(){
        return $this->object;
    }
}
?>