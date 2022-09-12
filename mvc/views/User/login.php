<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Madurai:wght@300&display=swap" rel="stylesheet">
    <link href="fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        *{
    margin:0;
    padding:0;
    box-sizing: border-box;
    font-size:16px;
}
body {
  font-family: "Poppins", sans-serif;
  height: 100vh;
  background-color: white;
}

a {
    width:85%;
  color: #5555f4;
  display:inline-block;
  text-decoration: underline;
  text-align: right;
  font-weight: 400;
}

h2 {
  text-align: left;
  margin: 5px;
  font-size:16px;
  font-weight: 600;
  display:inline-block;
  margin: 10px 0px; 
  color: #666666;
}
    .wrapper {
  display: flex;
  align-items: center;
  flex-direction: column; 
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;
}

#formContent {
  -webkit-border-radius: 10px 10px 10px 10px;
  border-radius: 10px 10px 10px 10px;
  background: #fff;
  padding: 30px;
  width: 90%;
  max-width: 450px;
  position: relative;
  padding: 0px;
}
input[type="text"], input[type="password"] {
    width: 85%;
    height: 40px;
    border: 1px solid #bddad5;
    padding: 10px;
    border-radius: 5px;
}
.validate{
    font-weight: bold;
}
#login_withFb{
    text-align: right;
}
input[type="submit"] {
    background-color: #1ba1e2;
    padding: 10px 30px;
    border-radius: 5px;
    color: white;
    border: none;
    text-align:center;
    margin: auto;
}
.row{
    width: 85%;
}

    </style>
  </head>
    <body>
          <div class="wrapper">
            <div id="formContent">
              <?php
                if(isset($data['result'])){
                  if($data['result']=="true"){

                  }
                  else{?>
                    <h5>
                      <?php echo "Đăng nhập thất bại"; ?>
                    </h5>
                  <?php }
                }
              ?>
              <form action="Login/login" method="POST">
                <div>
                    <h2>Email</h2>
                </div>
                <input type="text" id="email" name="email">
                <div>
                    <p id=" validate--username" class="validate" style="color:red; font-size:12px">Email cannot be blank</p>
                </div>
                <div>
                    <h2>Password</h2>
                </div>
                <input type="password" id="password" name="password">
                <div>
                    <p id=" validate--password" class="validate" style="color:red; font-size:12px">Password cannot be blank</p>
                </div>
                <div>
                    <a href="#" id="login_withFb">Login via Facebook</a>
                </div>
                <div class="row">
                    <input onclick="" name="submit" type="submit" value="Log In">
                </div>
              </form>
            </div>
          </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>