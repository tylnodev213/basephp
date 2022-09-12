<!doctype html>
<html lang="en">
  <head>
    <title>Profile</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    li{
        list-style: none;
    }
        .header_navbar{
            width:100%;
            border-top:1px solid #eee2ea;
            border-bottom:1px solid #eee2ea;
            text-align:right;
            padding: 10px 10%;
        }
        .logout_btn{
            width:100%;
            font-weight: 600;
        }
        .header_title{
            width: 100%;
            padding: 50px 10%;
        }
        .profile_border{
            width: 80%;
            height: 60vh;
            border: 1px solid black;
            margin: 0px 10%;
        }
        .profile_info{
            width: 100%;
            padding:30px 5%;
        }
        .profile_info__left{
            width:10%;
        }
        .profile_info__right{
            width:90%;
        }
        .row{
            margin-left:0px;
            margin-right:0px;
        }
        .img_profile{
            width: 10%;
        }
  </style>
  <body>
      <div class="header_navbar">
        <a href="#" class="logout_btn">Logout</a>
      </div>
      <div class="header_title">
        <p>My Profile<h1>
      </div>
      <div class="profile_border">
        <ul class="profile_info">
            <li class="row">
                <div class="profile_info__left">ID</div>
                <div class="profile_info__right">10</div>
            </li>
            <li class="row">
                <div class="profile_info__left">Avatar</div>
                <div class="profile_info__right">
                    <img class="img_profile" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPyGNr2qL63Sfugk2Z1-KBEwMGOfycBribew&usqp=CAU">
                </div>
            </li>
            <li class="row">
                <div class="profile_info__left">Name</div>
                <div class="profile_info__right">Nguyen Van A</div>
            </li>
            <li class="row">
                <div class="profile_info__left">Email</div>
                <div class="profile_info__right">nguyenvana@gmail.com</div>
            </li>
        </ul>
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>