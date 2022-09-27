<?php
include_once('mvc/controllers/Interface/ActionInterface.php');
include_once('mvc/helpers/handleFile.php');
include_once('mvc/helpers/passwordEncryption.php');
include_once('mvc/helpers/getToken.php');
include_once('mvc/helpers/permission.php');

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
        if (!$validation) {
            $this->view($this->controller . "/login", ["email_input" => $email, "password_input" => $password]);
            return;
        }

        $password = passwordEncryption($password);
        $data = $this->model($this->controller . "Model")->checkLogin($email, $password)->fetch();
        
        if (empty($data['id'])) {
            setSessionMessage('Login', 'Fail');
            $this->view($this->controller . "/login", ["email_input" => $email, "password_input" => $password]);
            return;
        }

        $action = $this->setToken($email);

        if ($action) {

            setSessionAdmin('id', $data['id']);
            setSessionAdmin('role_type', $data['role_type']);

            //Redirect
            header("Location: " . DOMAIN . $this->controller . "/search");
            return;
        }

    }

    public function create()
    {
        //check login SESSION
        if (!checkPermission() && $this->checkToken()) {
            header("Location: " . DOMAIN);
        }

        $model = $this->model($this->controller . "Model");

        if (!isset($_POST['save'])) {
            $this->view($this->controller . "/create");
            return;
        }

        //validation
        $validation = 1;
        $avatar = uploadFile();
        $emailExist = $model->findByField(['email' => $_POST['email']])->fetch();
        if(!empty($emailExist)) {
            setSessionMessage('Email', DATA_EXISTED);
            $validation = 0;
        }
        $validation *= validation($_POST);

        //Data
        if (!$validation) {
            $this->view($this->controller . "/create", [
                'avatar' => $avatar,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'password_verify' => $_POST['password_verify'],
                'role_type' => $_POST['role_type']
            ]);
            return 0;
        }

        $password = passwordEncryption($_POST['password']);
        $data = [
            'avatar' => $avatar,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $password,
            'role_type' => $_POST['role_type']
        ];

        //Model
        $actioonSuccessfull = $model->create($data);
        //notice message action successfull
        if ($actioonSuccessfull) {
            setSessionActionSuccessful('Create');
        }

        //Redirect
        header("Location: " . DOMAIN . $this->controller . "/search");
    }

    public function search()
    {
        //check login SESSION && token
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
                'role_type' => $data['role_type']
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
                'role_type' => $_POST['role_type']
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
                'role_type' => $_POST['role_type']
            ]);
            return 0;
        }

        $password = passwordEncryption($_POST['password']);
        $data = [
            'avatar' => $avatar,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $password,
            'role_type' => $_POST['role_type']
        ];

        //Model
        $actioonSuccessfull = $model->update($id, $data);

        //notice message action successfull
        if ($actioonSuccessfull) {
            setSessionActionSuccessful('Update');
        }

        //Redirect
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
        $data = $model->findByField(['id' => $id])->fetch();
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
        if($id==getSessionAdmin('id')) {
            unset($_SESSION['admin']['id']);
            $this->model('UserTokenModel')->deleteById($_SESSION['email']);
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
