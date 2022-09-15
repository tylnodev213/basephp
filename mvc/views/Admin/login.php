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
                   style="color:red; font-size:12px"><?php echo checkSessionMessage('email') ? getSessionMessage('email') : ""; ?></p>
            </div>
            <div>
                <label for="password">Password</label>
            </div>
            <input type="password" id="password" name="password" value="<?php echo $data['password_input'] ?? ""; ?>">
            <div>
                <p id="validate--username" class="validate"
                   style="color:red; font-size:12px"><?php echo checkSessionMessage('password') ? getSessionMessage('password') : ""; ?></p>
            </div>
            <div class="row">
                <input type="submit" value="Log In">
            </div>
        </form>
    </div>
</div>
<?php
include_once("mvc/views/layouts/footer.php");
?>