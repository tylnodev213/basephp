<?php
include_once('mvc/controllers/ActionInterface.php');
include_once('mvc/helpers/uploadFile.php');
include_once('vendor/facebook/graph-sdk/src/Facebook/autoload.php');
class UserController extends Controller implements ActionInterface
{

    public $controller;

    public function __construct()
    {
        $this->controller = "User";
        //check login SESSION
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
                header("Location: " . DOMAIN . "User/profile");
                return;
            } else {
                setSessionMessage('Login', 'Fail');
            }
        }

        $this->view($this->controller . "/login", ["email_input" => $email, "password_input" => $password]);

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
        $data = $model->searchData($condition,"");
        $total_record = $model->searchData($condition,"getTotalRecord")->fetch();
        //View
        $this->view($this->controller . "/search", ["data" => $data, "total_record"=>$total_record]);
    }

    public function create()
    {
        $model = $this->model($this->controller . "Model");

        //validation
        $avatar = uploadFile();

        $validation = validation($_POST);

        //Data
        if (!$validation) {
            $this->view($this->controller . "/create", [
                'avatar' => $avatar,
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'status' => $_POST['status']
            ]);
            return 0;
        }
        $data = [
            'avatar' => $avatar,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'status' => $_POST['status']
        ];
        //Model
        $actioonSuccessfull = $model->create($data);
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
                'status' => $_POST['status']
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
            $data = $model->findById($id, 'id');
            $this->view($this->controller . "/edit", ["data" => $data]);
        }
    }

    public function delete($id)
    {
        $model = $this->model($this->controller."Model");
        // find del_flag
        $data = $model->findById($id, 'id')->fetch();
        // del_flag dirrection
        if(!empty($data) && $data['del_flag'] == DELETED_OFF) {
            $actioonSuccessfull = $model->update($id, ['del_flag'=>DELETED_ON]);
        }else {
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
        $this->view("User/login", [
        ]);
    }

    public function profile()
    {
        $model = $this->model($this->controller."Model");
        $data = $model->findById(getSessionUser('id'), 'id');
        $this->view($this->controller . "/profile", [
            'data'=>$data
        ]);
    }
    public function fb_callback()
    {
        $loginFacebook = new LoginFacebook($this);
        $facebookData = $loginFacebook->fb_callback();
        $facebookId = $facebookData['facebook_id'];

        $model = $this->model($this->controller."Model");
        $account_exist = $model->findById($facebookId, 'facebook_id');

        if(!$account_exist) {
            $_POST = $facebookData;
            $this->create();
        }

        $this->profile();
    }

}
