<?php

class DB
{
    private static $instance = NULl;
    public static function getInstance() {
      if (!isset(self::$instance)) {
        try {
          self::$instance = new PDO('mysql:host=localhost;dbname=basephp', 'root', '');
          self::$instance->exec("SET NAMES 'utf8'");
        } catch (PDOException $ex) {
          die($ex->getMessage());
        }
      }
      return self::$instance;
    }
    public function select($sql)
    {
        $connect = $this -> getInstance();
        $result = $connect->query($sql);

        $connect=NULL;

        return $result;
    }
}