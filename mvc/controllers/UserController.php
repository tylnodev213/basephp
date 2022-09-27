<?php
include_once('mvc/controllers/Interface/ActionInterface.php');
include_once('mvc/controllers/Decorator.php');
include_once('mvc/controllers/LoginFacebook.php');
include_once('mvc/helpers/handleFile.php');
include_once('mvc/helpers/permission.php');
include_once('mvc/helpers/passwordEncryption.php');
include_once('mvc/helpers/getToken.php');
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

        if (!isset($_POST['submit'])) {
            $this->view($this->controller . "/login", ["email_input" => $email, "password_input" => $password]);
            return;
        }

        //validation
        $validation = validation([
            'email' => $email,
            'password' => $password
        ]);

        //check data in db
        if ($validation) {
            $password = passwordEncryption($password);
            $data = $this->model($this->controller . "Model")->checkLogin($email, $password)->fetch();
        }

        if (!empty($data['id'])) {
            setSessionUser('id', $data['facebook_id']);
            setSessionUser('status', $data['status']);
            $this->setToken($email);
            header("Location: " . DOMAIN . $this->controller . "/profile");
            return;
        }
        setSessionMessage('Login', 'Fail');
        $this->view($this->controller . "/login", ["email_input" => $email, "password_input" => $password]);



    }

    public function search()
    {
        //check login SESSION
        if (!checkPermission() || $this->checkToken()) {
            header("Location: " . DOMAIN);
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
        $data = $model->searchData($condition, "");
        $total_record = $model->searchData($condition, "getTotalRecord")->fetch();

        //View
        $this->view($this->controller . "/search", ["data" => $data, "total_record" => $total_record]);
    }

    public function edit($id)
    {
        //check login SESSION
        if (!checkPermission() || $this->checkToken()) {
            header("Location: " . DOMAIN);
        }

        $model = $this->model($this->controller . 'Model');

        if (!isset($_POST['save'])) {
            $data = $model->findByField(['id'=>$id])->fetch();
            if(empty($data)){
                phpAlert(DATA_NOT_EXIST, $this->controller);
                return;
            }
            $this->view($this->controller . "/edit", [
                'id' => $data['id'],
                'name' => $data['name'],
                'avatar' => $data['avatar'],
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => $data['status']
            ]);
            return;
        }

        //Data
        $avatar = uploadFile();
        //Validate
        $validation = 1;
        $emailExist = $model->findByField(['email' => $_POST['email'], 'not_id' => $id])->fetch();
        if(!empty($emailExist)) {
            setSessionMessage('Email', DATA_EXISTED);
            $validation = 0;
        }
        if(empty($_POST['password']) && empty($_POST['password_verify'])) {
            $validation *= validation([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'status' => $_POST['status']
            ]);
        }else {
            $validation *= validation($_POST);
        }

        if (!$validation) {
            $this->view($this->controller . "/edit", [
                'id' => $id,
                'avatar' => $avatar,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'password_verify' => $_POST['password_verify'],
                'status' => $_POST['status']
            ]);
            return 0;
        }

        $password = passwordEncryption($_POST['password']);
        $data = [
            'avatar' => $avatar,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $password,
            'status' => $_POST['status']
        ];

        //Model
        $actioonSuccessfull = $model->update($id, $data);

        //notice message action successfull
        if ($actioonSuccessfull) {
            setSessionActionSuccessful('Update');
        }

        //View
        header("Location: " . DOMAIN . $this->controller . "/search");
    }

    public function delete($id)
    {
        //check login SESSION
        if (!checkPermission() || $this->checkToken()) {
            header("Location: " . DOMAIN);
        }

        $model = $this->model($this->controller . 'Model');

        // find del_flag
        $data = $model->findByField(['id'=>$id])->fetch();
        if(empty($data)){
            phpAlert(DATA_NOT_EXIST, $this->controller);
            return;
        }
        // del_flag dirrection
        if (!empty($data) && $data['del_flag'] == DELETED_OFF) {
            $actioonSuccessfull = $model->update($id, ['del_flag' => DELETED_ON]);
        } else {
            removeFile($data['avatar']);
            $actioonSuccessfull = $model->deleteById($id);
        }

        //notice message action successfull
        if ($actioonSuccessfull) {
            setSessionActionSuccessful('Delete');
        }

        //Redirect
        header("Location: " . DOMAIN . $this->controller . "/search");
    }

    public function logout()
    {
        if (isset($_SESSION['email'])) {
            $this->model('UserTokenModel')->deleteById($_SESSION['email']);
        }

        $this->view($this->controller . "/login", [
        ]);

        session_destroy();
    }

    public function fb_callback()
    {
        //Decorator Login Facebook
        $loginFacebook = new LoginFacebook($this);

        $facebookData = $loginFacebook->callback();
        $facebookEmail = $facebookData['email'];
        $facebookId = $facebookData['facebook_id'];

        $model = $this->model($this->controller . "Model");
        $account_exist = $model->findByField(['facebook_id'=>$facebookId])->fetch();

        if (!empty($account_exist)) {
            setSessionUser('id', $facebookId);
            setSessionUser('status',$account_exist['status']);
            $this->setToken($facebookEmail);
            header('Location: '.DOMAIN.'User/profile');
            return;
        }

        $_POST = $facebookData;

        $createAccount = $this->create();
        if (!$createAccount) {
            setSessionMessage('Login', 'Fail');
            $this->view($this->controller.'/login');
        }

        $data = $model->checkLogin($facebookEmail, NULL)->fetch();
        if (empty($data['id'])) {
            setSessionMessage('Login', 'Fail');
            $this->view($this->controller.'/login');
            return;
        }

        $action = $this->setToken($facebookEmail);

        if($action) {
            setSessionUser('id', $data['facebook_id']);
            setSessionUser('status',$data['status']);
            $this->profile();
        }

    }

    public function profile()
    {
        //check login SESSION
        if (!checkPermission() || $this->checkToken()) {
            header("Location: " . DOMAIN);
        }

        $model = $this->model($this->controller . "Model");

        $data = $model->findByField(['facebook_id'=>getSessionUser('id')]);

        $this->view($this->controller . "/profile", [
            'data' => $data
        ]);
    }

    public function create()
    {
        $model = $this->model($this->controller . "Model");
        //validation
        $validation = validation($_POST);

        if (!$validation) {
            return 0;
        }

        $data = [
            'avatar' => $_POST['avatar'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'facebook_id' => $_POST['facebook_id']
        ];

        //Model
        return $model->create($data);
    }

    public function checkToken()
    {
        if (!isset($_SESSION['email'])) {
            return 1;
        }

        $data = $this->model('UserTokenModel')->findByField(['email'=>$_SESSION['email']])->fetch();
        if (empty($data['token'])) {
            return 1;
        }

        $token = $data['token'];
        if ($_SESSION['token'] != $token) {
            return 1;
        }

        return 0;
    }

    public function setToken($email) {
        $model = $this->model('UserTokenModel');
        $token = getToken(10);

        $_SESSION['email'] = $email;
        $_SESSION['token'] = $token;

        $row_token = $model->count($email)->fetch();

        if (!empty($row_token['allcount'])) {
            return $model->update($email, $token);
        } else {
            return $model->create(array('email' => $email, 'token' => $token));
        }
    }

}
