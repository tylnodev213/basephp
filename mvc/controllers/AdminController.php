<?php
include_once('mvc/helpers/uploadFile.php');

class AdminController extends Controller
{

    public $controller;

    public function __construct()
    {
        $this->controller = "Admin";
    }

    public function logIn()
    {
        //checkAdminSESSION
        if(checkAdminLogin()){
            $this->search();
        }
        $email = $_POST['email'] ?? "";
        $password = $_POST['password'] ?? "";

        //check email blank

        $validation = validation([
            "email" => $email,
            "password" => $password
        ]);

        //check data in db
        if ($validation) {
            $data = $this->model($this->controller . "Model")->checkLogin($email, $password)->fetch();
        } else {
            $this->view($this->controller . "/login");
        }

        if (isset($data)) {
            setSessionAdmin('id', $data['id']);
            $this->search();
        }

    }

    public function search()
    {
        //GET condition
        $email = $_GET["email"] ?? "";
        $name = $_GET["name"] ?? "";
        $condition = [
            'email' => $email,
            'name' => $name
        ];
        //Model
        $model = $this->model($this->controller . "Model");
        $data = $model->searchData($condition);
        //View
        $this->view($this->controller . "/search", ["data" => $data]);
    }

    public function create()
    {
        $model = $this->model($this->controller . "Model");

        if (isset($_POST['save'])) {
            //Data
            $avatar = uploadFile();
            $data = [
                'avatar' => $avatar,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role_type' => $_POST['role_type']
            ];
            //Model
            $actioonSuccessfull = $model->create($data);
            //notice message action successfull
            if ($actioonSuccessfull) {
                setSessionActionSuccessful('Create');
            }
            //View
            $this->search();
        } else {
            $this->view($this->controller . "/create");
        }
    }

    public function edit($id)
    {
        $model = $this->model($this->controller . 'Model');

        if (isset($_POST['save'])) {
            //Data
            $avatar = uploadFile();
            $data = [
                'avatar' => $avatar,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role_type' => $_POST['role_type']
            ];
            //Model
            $actioonSuccessfull = $model->update($id, $data);
            //notice message action successfull
            if ($actioonSuccessfull) {
                setSessionActionSuccessful('Update');
            }
            //View
            $this->search();
        } else {
            $data = $model->findById($id);
            $this->view($this->controller . "/edit", ["data" => $data]);
        }
    }

    public function delete($id)
    {
        $model = $this->model($this->controller . 'Model');
        // delete record
        $actioonSuccessfull = $model->deleteById($id);
        //notice message action successfull
        if ($actioonSuccessfull) {
            setSessionActionSuccessful('Update');
        }
        $this->search();
    }

    public function logout()
    {
        unset($_SESSION[$this->controller]['id']);
        $this->view($this->controller . "/login", [
        ]);
    }
}
