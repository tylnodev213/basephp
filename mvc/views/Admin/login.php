<?php
include_once("mvc/views/layouts/header.php");
?>
<body>
  <div class="wrapper">
    <div id="formContent">
      <form action="logIn" method="POST" enctype="multipart/form-data">
        <div>
          <h2>Email</h2>
        </div>
        <input type="text" id="email" name="email" value="<?php  echo $data['email_input'] ?? "";?>">
        <div>
          <?php
            if(checkSessionMessage('email')){
          ?>
            <p id=" validate--username" class="validate" style="color:red; font-size:12px"><?php echo getSessionMessage('email'); ?></p>
          <?php
            }
          ?>
        </div>
        <div>
          <h2>Password</h2>
        </div>
        <input type="password" id="password" name="password" value="<?php  echo $data['password_input'] ?? "";?>">
        <div>
        <?php
            if(checkSessionMessage('passord')){
          ?>
            <p id=" validate--username" class="validate" style="color:red; font-size:12px"><?php echo getSessionMessage('password'); ?></p>
          <?php
            }
          ?>
        </div>
        <div class="row">
          <input onclick="" name="submit" type="submit" value="Log In">
        </div>
      </form>
    </div>
  </div>
  <?php
  include_once("mvc/views/layouts/footer.php");
  ?>