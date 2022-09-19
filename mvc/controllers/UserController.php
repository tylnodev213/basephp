<?php
include_once('mvc/controllers/Interface/ActionInterface.php');
include_once('mvc/controllers/Decorator.php');
include_once('mvc/controllers/LoginFacebook.php');
include_once('mvc/helpers/handleFile.php');
include_once('vendor/facebook/graph-sdk/src/Facebook/autoload.php');
class UserController extends Controller implements ActionInterface
{

    public $controller;

    public function __construct()
    {
        $this->controller = "User";
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
                setSessionUser('id', $data['id']);
                header("Location: " . DOMAIN . $this->controller."/profile");
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

        $validation = validation($_POST);

        if(!$validation) {
            return 0;
        }
        $data = [
            'avatar' => $_POST['avatar'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'facebook_id' => $_POST['facebook_id']
        ];
        //Model
        $model->create($data);
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
                    'id'=> $id,
                    'avatar' => $avatar,
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'password_verify' => $_POST['password_verify'],
                    'status' => $_POST['status']
                ]);
                return 0;
            }

            saveFile($avatar);
            $data = [
                'avatar' => $avatar,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'status' => $_POST['status']
            ];
            //Model
            $actioonSuccessfull = $model->update($id, $data);
            //notice message action successfull
            if ($actioonSuccessfull) {
                setSessionActionSuccessful('Update');
            }
            //View
            header("Location: ".DOMAIN.$this->controller."/search");
        } else {
            $data = $model->findById($id, 'id')->fetch();
            $this->view($this->controller . "/edit", [
                'id' => $data['id'],
                'name' => $data['name'],
                'avatar' => $data['avatar'],
                'email' => $data['email'],
                'password'=>$data['password'],
                'status'=>$data['status']
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
        header("Location: ".DOMAIN.$this->controller."/search");
    }

    public function logout()
    {
        unset($_SESSION['admin']['id']);
        unset($_SESSION['user']['id']);
        $this->view($this->controller."/login", [
        ]);
    }

    public function profile()
    {
        //check login SESSION
        if(!checkSessionLogin('user')) {
            header("Location: ".DOMAIN."User/login");
        }
        $model = $this->model($this->controller."Model");
        $data = $model->findById(getSessionUser('id'), 'facebook_id');
        $this->view($this->controller . "/profile", [
            'data'=>$data
        ]);
    }
    public function fb_callback()
    {
        //Decorator Login Facebook
        $loginFacebook = new LoginFacebook($this);

        $facebookData = $loginFacebook->fb_callback();
        $facebookEmail = $facebookData['email'];
        $facebookId = $facebookData['facebook_id'];

        $model = $this->model($this->controller."Model");
        $account_exist = $model->findById($facebookId, 'facebook_id')->fetch();

        if(!empty($account_exist)) {
            setSessionUser('id', $account_exist['facebook_id']);
            $this->profile();
            return;
        }

        $_POST = $facebookData;
        $createAccount = $this->create();
        if(!$createAccount) {
            $this->login();
            return;
        }

        $data = $model->checkLogin($facebookEmail, NULL)->fetch();
        if (empty($data['id'])) {
            $this->login();
            return;
        }

        setSessionUser('id', $data['facebook_id']);
        $this->profile();

    }

}
