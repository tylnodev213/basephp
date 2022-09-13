<?php
class Admin extends Controller{
    public function logIn(){
        $result_mess = false;
        $blank_input = "";
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password_input = $_POST['password'];
            if(empty($_POST['email']) && empty($_POST['password'])){
                $blank_input="blank";
                $this->view('Admin/login',[
                    "result"=>$result_mess,
                    "blank_input" => $blank_input,
                ]);
            }else if(empty($_POST['email']) || empty($_POST['password'])){
                if(empty($_POST['email'])){
                    $blank_input="blank_email";
                }else if(empty($_POST['password'])){
                    $blank_input="blank_password";
                }
                $this->view('Admin/login',[
                    "result"=>$result_mess,
                    "blank_input" => $blank_input,
                    "email_input"=>$email,
                    "password_input"=>$password_input,
                ]);
            }   
            $result = ($this->model("AdminModel"))->login($email);
            if($result->rowCount()>0){
                foreach($result as $row){
                    $id = $row['id'];
                    $email = $row['email'];
                    $password = $row['password'];
                    $del_flag = $row['del_flag'];
                }
                if(strcmp($password_input,$password)==0 && $del_flag==DELETED_OFF){
                    setSessionAdmin('id', $id);
                    $this->index();
                }else{
                    $this->view("Admin/login",[
                        "result"=>$result_mess,
                    ]);
                }
            }else{
                $this->view("Admin/login",[
                    "result"=>$result_mess,
                ]);
            }
        }
        else if(checkAdminLogin()){
            $this->index();
        }else{
            $this->view("Admin/login",[
            ]);
        }
    }
    public function index(){
        $model = $this->model('AdminModel');
        if(isset($_GET['field'])){
            $arr=$model->sortByField();
        }else{
            $arr=$model->getAll(['id','name','email','avatar','role_type','del_flag']);
        }
        $this->view("Admin/index",["arr" => $arr]);
    }
    public function search(){
        $email = $_GET["email"] ?? "";
        $name = $_GET["name"] ?? "";
        $model = $this->model('AdminModel');
        $arr=$model->find($email,$name);
        $this->view("Admin/search",["arr" => $arr]);       
    }
    public function create()
    {
        if(isset($_POST['submit'])){
            $model=$this->model('AdminModel');
            unset($_POST['password_verify'],$_POST['submit']);
            $model->create($_POST);
            $this->index();
        }else{
            $this->view("Admin/create");
        }
    }
    public function edit($id){  
        if(isset($_POST['submit'])){
            $model=$this->model('AdminModel');
            unset($_POST['password_verify'],$_POST['submit']);
            $model->update($id,$_POST);
            $this->index();
        }else{
            $model = $this->model('AdminModel');
            $result=$model->findById($id);
            $this->view("Admin/edit",[
                "id"=>$id,
                "arr"=>$result
            ]);
        }
    }
    public function delete($id){
        $model=$this->model('AdminModel');
        $model->deleteById($id);
        $this->index();
    }
    public function logout(){
        unset($_SESSION[$this->controller]['id']);
        $this->view("Admin/login",[
        ]);
    }
}
