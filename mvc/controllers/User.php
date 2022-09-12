<?php
class User extends Controller{
    public function logIn(){
        $this->view('User/login',[

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
                $this->view('User/login',[
                    "result"=>$result_mess,
                    "blank_input" => $blank_input,
                ]);
            }else if(empty($_POST['email']) || empty($_POST['password'])){
                if(empty($_POST['email'])){
                    $blank_input="blank_email";
                }else if(empty($_POST['password'])){
                    $blank_input="blank_password";
                }
                $this->view('User/login',[
                    "result"=>$result_mess,
                    "blank_input" => $blank_input,
                    "email_input"=>$email,
                    "password_input"=>$password_input,
                ]);
            }   
            $result = ($this->model("UserModel"))->login($email);
            if($result->rowCount()>0){
                foreach($result as $row){
                    $id = $row['id'];
                    $email = $row['email'];
                    $password = $row['password'];
                    $del_flag = $row['del_flag'];
                }
                if(strcmp($password_input,$password)==0 && $del_flag==DELETED_OFF){
                    setSessionUser('id', $id);
                    $this->show();
                }else{
                    $this->view("User/login",[
                        "result"=>$result_mess,
                    ]);
                }
            }else{
                $this->view("User/login",[
                    "result"=>$result_mess,
                ]);
            }
        }
        else if(checkUserLogin()){
            $this->show();
        }else{
            $this->view("User/login",[
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
        $model = $this->model('UserModel');
        $arr=$model->find($email,$name);
        $this->view("User/search",["arr" => $arr]);       
    }
    public function create()
    {
        if(isset($_POST['submit'])){
            $model=$this->model('UserModel');
            unset($_POST['password_verify'],$_POST['submit']);
            $model->create($_POST);
            $this->show();
        }else{
            $this->view("User/create");
        }
    }
    public function edit($id){  
        if(isset($_POST['submit'])){
            $model=$this->model('UserModel');
            unset($_POST['password_verify'],$_POST['submit']);
            $model->update($id,$_POST);
            $this->show();
        }else{
            $model = $this->model('UserModel');
            $result=$model->findById($id);
            $this->view("User/edit",[
                "id"=>$id,
                "arr"=>$result
            ]);
        }
    }
    public function delete($id){
        $model=$this->model('UserModel');
        $model->deleteById($id);
        $this->show();
    }
    public function logout(){
        unset($_SESSION[$this->controller]['id']);
        $this->view("User/login",[
        ]);
    }
}
?>