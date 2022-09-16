<?php
include_once('mvc/helpers/uploadFile.php');
include_once('vendor/facebook/graph-sdk/src/Facebook/autoload.php');
class UserController extends Controller
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
            //notice message action successfull
            if ($actioonSuccessfull) {
                setSessionActionSuccessful('Create');
            }
            //View
            header("Location: ".DOMAIN."Admin/search");

        }
        $this->view($this->controller . "/create");

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
            $data = $model->findById($id);
            $this->view($this->controller . "/edit", ["data" => $data]);
        }
    }

    public function delete($id)
    {
        $model = $this->model($this->controller."Model");
        // find del_flag
        $data = $model->findById($id)->fetch();
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
        unset($_SESSION[$this->controller]['id']);
        $this->view($this->controller . "/login", [
        ]);
    }

    public function profile()
    {
        $model = $this->model($this->controller."Model");
        $data = $model->findById(getSessionUser('id'));
        $this->view($this->controller . "/profile", [
            'data'=>$data
        ]);
    }

    public function loginFacebook()
    {
        $fb = new Facebook\Facebook([
            'app_id' => '759351248655188', // Replace {app-id} with your app id
            'app_secret' => '8de01d92a631b2eb340496f219a3671f',
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(DOMAIN.'User/fb_callback', $permissions);

        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }

    public function fb_callback()
    {
        $fb = new Facebook\Facebook([
            'app_id' => '759351248655188', // Replace {app-id} with your app id
            'app_secret' => '8de01d92a631b2eb340496f219a3671f',
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

// Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('{app-id}'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
    header('Location:'.DOMAIN.'User/profile');

    }
}
