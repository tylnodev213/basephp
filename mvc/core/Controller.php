<?php
include_once ("mvc/helpers/common.php");
class Controller{

    public function model($model){
        require_once "./mvc/models/".$model.".php";
        return new $model;
    }

    public function view($view, $data=[]){
        if($view=="Admin/search" && ($_SERVER['REQUEST_URI'] !="/basephp/Admin/search")) {
            header("Location: ".DOMAIN."Admin/search");
            return;
        }
        if($view=="User/search" && ($_SERVER['REQUEST_URI'] !="/basephp/User/search")) {
            header("Location: " . DOMAIN . "User/search");
            return;
        }
        require_once "./mvc/views/".$view.".php";

    }
}
?>