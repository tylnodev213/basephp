<?php
include_once("mvc/views/layouts/header.php");
?>
<body>
<div class="wrapper">
    <div id="formContent">
        <form action="login" method="POST" enctype="multipart/form-data">
            <div>
                <label for="email">Email</label>
            </div>
            <input type="text" id="email" name="email" value="<?php echo $data['email_input'] ?? ""; ?>">
            <div>
                <p id="validate--username" class="validate"
                   style="color:red; font-size:12px"><?php echo checkSessionMessage('Email') ? getSessionMessage('Email') : ""; unsetSessionMessage("Email"); ?></p>
            </div>
            <div>
                <label for="password">Password</label>
            </div>
            <input type="password" id="password" name="password" value="<?php echo $data['password_input'] ?? ""; ?>">
            <div>
                <p id="validate--username" class="validate"
                   style="color:red; font-size:12px"><?php echo checkSessionMessage('Password') ? getSessionMessage('Password') : (checkSessionMessage('Login') ? getSessionMessage('Login') : ""); unsetSessionMessage("Password");unsetSessionMessage("Login"); ?></p>
            </div>
            <div>
                <?php
                $facebook = new Facebook\Facebook([
                    'app_id' => '759351248655188', // Replace {app-id} with your app id
                    'app_secret' => '8de01d92a631b2eb340496f219a3671f',
                    'default_graph_version' => 'v15.0',
                ]);

                $facebook_helper = $facebook->getRedirectLoginHelper();

                $facebook_permissions = ['email']; // Optional permissions

                $facebook_login_url = $facebook_helper->getLoginUrl(DOMAIN."User/fb_callback", $facebook_permissions);
                ?>
                <a href="<?php echo $facebook_login_url ?>" onclick="return confirm('Confirm login with Facebook')" >Login via Facebook</a>
            </div>
            <div class="row">
                <input type="submit" name="submit" value="Log In">
            </div>
        </form>
    </div>
</div>
<?php
include_once("mvc/views/layouts/footer.php");
?>
