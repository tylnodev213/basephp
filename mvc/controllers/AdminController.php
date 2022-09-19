<?php
include_once('mvc/controllers/Interface/ActionInterface.php');
include_once('mvc/helpers/handleFile.php');

class AdminController extends Controller implements ActionInterface
{

    public $controller;

    public function __construct()
    {
        $this->controller = "Admin";
    }

    public function login()
    {

        $email = $_POST['email'] ?? "";
        $password = $_POST['password'] ?? "";
        if (isset($_POST['submit'])) {
            //validation
            $validation = validation([
                'email' => $email,
                'password' => $password
            ]);

            //check data in db
            if ($validation) {
                $data = $this->model($this->controller . "Model")->checkLogin($email, $password)->fetch();
            }

            if (!empty($data['id'])) {
                setSessionAdmin('id', $data['id']);
                header("Location: " . DOMAIN . "Admin/search");
                return;
            } else {
                setSessionMessage('Login', 'Fail');
            }
        }

        $this->view($this->controller . "/login", ["email_input" => $email, "password_input" => $password]);

    }

    public function search()
    {

        //check login SESSION
        if(!checkSessionLogin('admin')) {
            header("Location: ".DOMAIN."Admin/login");
        }
        //GET condition
        $email = $_GET["email"] ?? "";
        $name = $_GET["name"] ?? "";
        $condition = [
            'email' => $email,
            'name' => $name
        ];
        //Model
        $model = $this->model($this->controller . "Model");
        $data = $model->searchData($condition,"");
        $total_record = $model->searchData($condition,"getTotalRecord")->fetch();
        //View
        $this->view($this->controller . "/search", ["data" => $data, "total_record"=>$total_record]);
    }

    public function create()
    {
        //check login SESSION
        if(!checkSessionLogin('admin')) {
            header("Location: ".DOMAIN."Admin/login");
        }
        $model = $this->model($this->controller . "Model");

        if (isset($_POST['save'])) {
            //validation
            $avatar = uploadFile();

            $validation = validation($_POST);

            //Data
            if (!$validation) {
                $this->view($this->controller . "/create",[
                    'avatar' => $avatar,
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'password_verify' => $_POST['password_verify'],
                    'role_type' => $_POST['role_type']
                ]);
                return 0;
            }

            saveFile($avatar);
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
            header("Location: ".DOMAIN."Admin/search");
            return 0;

        }
        $this->view($this->controller . "/create");

    }

    public function edit($id)
    {
        //check login SESSION
        if(!checkSessionLogin('admin')) {
            header("Location: ".DOMAIN."Admin/login");
        }
        $model = $this->model($this->controller . 'Model');

        if (isset($_POST['save'])) {
            //Data
            $avatar = uploadFile();
            //Validate
            $validation = validation($_POST);

            if (!$validation) {
                $this->view($this->controller . "/edit",[
                    'id' => $id,
                    'avatar' => $avatar,
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'password_verify' => $_POST['password_verify'],
                    'role_type' => $_POST['role_type']
                ]);
                return 0;
            }

            saveFile($avatar);
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
            header("Location: ".DOMAIN."Admin/search");
        } else {
            $data = $model->findById($id, 'id')->fetch();
            $this->view($this->controller . "/edit", [
                'id' => $data['id'],
                'name' => $data['name'],
                'avatar' => $data['avatar'],
                'email' => $data['email'],
                'password'=>$data['password'],
                'role_type'=>$data['role_type']
            ]);
        }
    }

    public function delete($id)
    {
        //check login SESSION
        if(!checkSessionLogin('admin')) {
            header("Location: ".DOMAIN."Admin/login");
        }
        $model = $this->model($this->controller . 'Model');
        // find del_flag
        $data = $model->findById($id, 'id')->fetch();
        // del_flag dirrection
        if(!empty($data) && $data['del_flag'] == DELETED_OFF) {
            $actioonSuccessfull = $model->update($id, ['del_flag'=>DELETED_ON]);
        }else {
            removeFile($data['avatar']);
            $actioonSuccessfull = $model->deleteById($id);
        }
        //notice message action successfull
        if ($actioonSuccessfull) {
            setSessionActionSuccessful('Delete');
        }
        header("Location: ".DOMAIN."Admin/search");
    }

    public function logout()
    {
        unset($_SESSION['admin']['id']);
        unset($_SESSION['user']['id']);
        $this->view($this->controller."/login", [
        ]);
    }
}
