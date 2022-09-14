<?php
include_once ('mvc/helpers/uploadFile.php');
class UserController extends Controller {

    public $controller;

    public function __construct()
    {
        $this->controller = "User";
    }

    public function logIn() {

        $email = $_POST['email'] ?? "";
        $password = $_POST['password'] ?? "";

        //check email blank

        $validation = validation([
            "email"=>$email,
            "password"=>$password
        ]);

        //check data in db
        if($validation) {
            $data = $this->model($this->controller."Model")->checkLogin($email,$password);
        }else {
            $this->view($this->controller."/login");
        }

        if(isset($data)){
            setSessionAdmin('id',2);
            $this->search();
        }

    }

    public function search()
    {
        $email = $_GET["email"] ?? "";
        $name = $_GET["name"] ?? "";
        $condition = [
            'email'=>$email,
            'name'=>$name
        ];
        $model = $this->model($this->controller."Model");
        $data = $model->searchData($condition);

        $this->view($this->controller."/search", ["data" => $data]);
    }

    public function create()
    {
        $model = $this->model($this->controller."Model");

        if (isset($_POST['submit'])) {
            $avatar = uploadFile();
            // get $_POST
            $data = [
                'avatar'=> $avatar,
                'name'=> $_POST['name'],
                'email'=> $_POST['email'],
                'password'=>$_POST['password'],
                'role_type'=>$_POST['role_type']
            ];
            // create record
            $model->create($data);
            // return view
            $this->search();
        } else {
            $this->view($this->controller."/create");
        }
    }

    public function edit($id)
    {
        $model = $this->model($this->controller.'Model');

        if (isset($_POST['submit'])) {
            $avatar = uploadFile();
            $data = [
                'avatar'=> $avatar,
                'name'=> $_POST['name'],
                'email'=> $_POST['email'],
                'password'=>$_POST['password'],
                'role_type'=>$_POST['role_type']
            ];
            //update record
            $model->update($id, $data);
            //return view
            $this->search();
        } else {
            $data = $model->findById($id);
            $this->view($this->controller."/edit", [
                "data" => $data
            ]);
        }
    }

    public function delete($id)
    {
        $model = $this->model($this->controller.'Model');
        $model->deleteById($id);
        $this->search();
    }

    public function logout()
    {
        unset($_SESSION[$this->controller]['id']);
        $this->view($this->controller."/login", [
        ]);
    }
}
