<?php
include_once("mvc/views/layouts/header.php");
?>
<body>
  <div class="wrapper">
    <div id="formContent">
      <?php
      if (isset($data['result'])) {
        if ($data['result'] == "true") {
        } else { ?>
          <h5>
            <?php echo "Đăng nhập thất bại"; ?>
          </h5>
      <?php }
      }
      ?>
      <form action="index" method="POST">
        <div>
          <h2>Email</h2>
        </div>
        <input type="text" id="email" name="email" value="<?php if (isset($data['email_input'])) {
                                                            echo $data['email_input'];
                                                          } ?>">
        <div>
          <?php if (isset($data['blank_input'])) {
            if ($data['blank_input'] == "blank_email" || $data['blank_input'] == "blank") { ?>
              <p id=" validate--username" class="validate" style="color:red; font-size:12px">Email cannot be blank</p>
          <?php }
          } ?>
        </div>
        <div>
          <h2>Password</h2>
        </div>
        <input type="password" id="password" name="password" value="<?php if (isset($data['password_input'])) {
                                                                      echo $data['password_input'];
                                                                    } ?>">
        <div>
          <?php if (isset($data['blank_input'])) {
            if ($data['blank_input'] == "blank_password" || $data['blank_input'] == "blank") { ?>
              <p id=" validate--password" class="validate" style="color:red; font-size:12px">Password cannot be blank</p>
          <?php }
          } ?>
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