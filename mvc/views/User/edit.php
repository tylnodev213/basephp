<?php
include_once("mvc/helpers/resetForm.php");
include_once("mvc/views/layouts/header.php");
include_once("mvc/views/layouts/navbar.php");
?>
    <div class="flow_url">
        <a href="search">Search </a><i class="arrow right"></i><a> Admin Edit</a>
    </div>
<?php
if (isset($data['data'])) {
    while ($each = $data['data']->fetch()) {
        ?>
        <form class="form_container" action="" method="POST" enctype="multipart/form-data">
            <div class="form_box">
                <div class="row form_input">
                    <div class="col-md-2">ID</div>
                    <p><?php echo $each['id']; ?></p>
                </div>
                <div class="row form_input">
                    <label class="col-md-2" for="inputGroupFile" aria-describedby="inputGroupFileAddon">Avatar*</label>
                    <input type="file" class="col-md-4 file_upload" name="avatar" id="inputGroupFile">
                </div>
                <div class="row form_input">
                    <div class="col-md-2"></div>
                    <img src="<?php echo "../../../basephp/public/img/" . $each['avatar'] ?>" class="avatar_profile"
                         id="preview">
                    <input type="hidden" name="old_avatar" value="<?php echo $each['avatar'] ?>">
                </div>
                <div class="row form_input">
                    <div class="col-md-2">Name*</div>
                    <input type="text" name="name" class="col-md-4 search_box__form--input"
                           value="<?php echo $each['name'] ?>">
                </div>
                <div class="row form_input">
                    <div class="col-md-2">Email*</div>
                    <input type="text" name="email" class="col-md-4 search_box__form--input"
                           value="<?php echo $each['email'] ?>">
                </div>
                <div class="row form_input">
                    <div class="col-md-2">Password*</div>
                    <input type="text" name="password" class="col-md-4 search_box__form--input"
                           value="<?php echo $each['password'] ?>">
                </div>
                <div class="row form_input">
                    <div class="col-md-2">Password Verify*</div>
                    <input type="text" name="password_verify" class="col-md-4 search_box__form--input">
                </div>
                <div class="row form_input">
                    <div class="col-md-2">Role*</div>
                    <input type="radio" name="role_type" value="1 " class="col-md-1 form_input" <?php
                    if ($each['status'] == 1) {
                    ?>checked<?php
                    }
                    ?>><label class="col-md-2 form_input">Active</label>
                    <input type="radio" name="role_type" value="2" class="col-md-1 form_input" <?php
                    if ($each['status'] == 2) {
                    ?>checked<?php
                    }
                    ?>><label class="col-md-2 form_input">Banned</label>
                </div>
            </div>
            <div class="row submit_box">
                <input type="submit" value="Reset" name="submit" class="search_box__btn__items">
                <input type="submit" value="Save" name="save"
                       class="search_box__btn__items search_box__btn__items--blue">
            </div>
        </form>
        <?php
    }
}
include_once("mvc/views/layouts/footer.php");
?>