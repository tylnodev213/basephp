<?php
include_once ("mvc/helpers/common.php");
class Controller{

    public function model($model){
        require_once "./mvc/models/".$model.".php";
        return new $model;
    }

    public function view($view, $data=[]){
        if($view=="Admin/index" && $_SERVER['REQUEST_URI'] !="/basephp/Admin/index"){
            header("Location: ".DOMAIN."/Admin/index");
        }else{
            require_once "./mvc/views/".$view.".php";
        }
    }
}
?>