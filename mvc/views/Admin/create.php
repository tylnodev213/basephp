<?php
include("mvc/views/layouts/header.php");
include("mvc/views/layouts/navbar.php");
?>
<div class="flow_url">
    <p>Admin Create</p>
</div>
<form class="form_container" action="" method="POST" enctype="multipart/form-data">
    <div class="form_box">
        <div class="row form_input">
            <label class="col-md-2" for="inputGroupFile" aria-describedby="inputGroupFileAddon">Avatar*</label>
            <input type="file" class="col-md-4 file_upload" name="avatar" id="inputGroupFile">
        </div>
        <div class="row form_input">
            <div class="col-md-2"></div>
            <img src="../public/img/avatar_default.png" class="avatar_profile"  id="preview">
        </div>
        <div class="row form_input">
            <div class="col-md-2">Name*</div>
            <input type="text" name="name" class="col-md-4 search_box__form--input">
        </div>
        <div class="row form_input">
            <div class="col-md-2">Email*</div>
            <input type="text" name="email" class="col-md-4 search_box__form--input">
        </div>
        <div class="row form_input">
            <div class="col-md-2">Password*</div>
            <input type="text" name="password" class="col-md-4 search_box__form--input">
        </div>
        <div class="row form_input">
            <div class="col-md-2">Password Verify*</div>
            <input type="text" name="password_verify" class="col-md-4 search_box__form--input">
        </div>
        <div class="row form_input">
            <div class="col-md-2">Role*</div>
            <input type="radio" name="role_type" value="1" class="col-md-1 form_input"><label class="col-md-2 form_input">Super Admin</label>
            <input type="radio" name="role_type" value="2" class="col-md-1 form_input"><label class="col-md-2 form_input">Admin</label>
        </div>
    </div>
    <div class="row submit_box">
        <input type="submit" value="reset" name="submit" class="search_box__btn__items">
        <input type="submit" value="save" name="submit" class="search_box__btn__items search_box__btn__items--blue">
    </div>
</form>
<?php
include_once ("mvc/views/layouts/footer.php");
?>