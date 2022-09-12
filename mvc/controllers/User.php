<?php
class Base extends Controller{
    public $controller ="User";
    public function logIn(){
        $this->view($this->controller.'/login',[

        ]);
    }
    public function index(){
        $result_mess = false;
        $blank_input = "";
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password_input = $_POST['password'];
            if(empty($_POST['email']) && empty($_POST['password'])){
                $blank_input="blank";
                $this->view($this->controller.'/login',[
                    "result"=>$result_mess,
                    "blank_input" => $blank_input,
                ]);
            }else if(empty($_POST['email']) || empty($_POST['password'])){
                if(empty($_POST['email'])){
                    $blank_input="blank_email";
                }else if(empty($_POST['password'])){
                    $blank_input="blank_password";
                }
                $this->view($this->controller.'/login',[
                    "result"=>$result_mess,
                    "blank_input" => $blank_input,
                    "email_input"=>$email,
                    "password_input"=>$password_input,
                ]);
            }   
            $result = ($this->model($this->controller."model"))->login($email);
            if($result->rowCount()>0){
                foreach($result as $row){
                    $id = $row['id'];
                    $email = $row['email'];
                    $password = $row['password'];
                    $del_flag = $row['del_flag'];
                }
                if(strcmp($password_input,$password)==0 && $del_flag==DELETED_OFF){
                    if($this->controller=='Admin'){
                        setSessionAdmin('id', $id);
                    }
                    if($this->controller=='User'){
                        setSessionUser('id', $id);
                    }
                    $this->show();
                }else{
                    $this->view($this->controller."/login",[
                        "result"=>$result_mess,
                    ]);
                }
            }else{
                $this->view($this->controller."/login",[
                    "result"=>$result_mess,
                ]);
            }
        }
        else if(checkAdminLogin() || checkUserLogin()){
            $this->show();
        }else{
            $this->view($this->controller."/login",[
            ]);
        }
    }
    public function show(){
        $model = $this->model('UserModel');
        $arr=$model->getAll(['id','name','email','avatar','status','del_flag']);
        $this->view("User/index",["arr" => $arr]);
    }
    public function search(){
        $email = $_GET["email"] ?? "";
        $name = $_GET["name"] ?? "";
        $model = $this->model($this->controller.'Model');
        $arr=$model->find($email,$name);
        $this->view($this->controller."/search",["arr" => $arr]);       
    }
    public function create()
    {
        if(isset($_POST['submit'])){
            $model=$this->model($this->controller.'Model');
            unset($_POST['password_verify'],$_POST['submit']);
            $model->create($_POST);
            $this->show();
        }else{
            $this->view($this->controller."/create");
        }
    }
    public function edit($id){  
        if(isset($_POST['submit'])){
            $model=$this->model($this->controller.'Model');
            unset($_POST['password_verify'],$_POST['submit']);
            $model->update($id,$_POST);
            $this->show();
        }else{
            $model = $this->model($this->controller.'Model');
            $result=$model->findById($id);
            $this->view($this->controller."/edit",[
                "id"=>$id,
                "arr"=>$result
            ]);
        }
    }
    public function delete($id){
        $model=$this->model($this->controller.'Model');
        $model->deleteById($id);
        $this->show();
    }
    public function logout(){
        unset($_SESSION[$this->controller]['id']);
        $this->view($this->controller."/login",[
        ]);
    }
}
?>