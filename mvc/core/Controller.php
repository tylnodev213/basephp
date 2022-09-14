<?php
include_once ("mvc/helpers/common.php");
class Controller{

    public function model($model){
        require_once "./mvc/models/".$model.".php";
        return new $model;
    }

    public function view($view, $data=[]){
        if($view=="Admin/search" && ($_SERVER['REQUEST_URI'] !="/basephp/Admin/search") && !isset($_GET)) {
            header("Location: ".DOMAIN."Admin/search");
            return true;
        }
        if($view=="User/search" && ($_SERVER['REQUEST_URI'] !="/basephp/User/search") && !isset($_GET)) {
            header("Location: " . DOMAIN . "User/search");
            return true;
        }
        require_once "./mvc/views/".$view.".php";

    }
}
?>