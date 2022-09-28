<?php
include_once("mvc/views/layouts/header.php");
?>
<body>
<div class="header_navbar">
    <a href="logout" class="logout_btn">Logout</a>
</div>
<div class="header_title">
    <p>My Profile
    <h1>
</div>
<?php
while ($each = $data["data"]->fetch()) { ?>
<div class="profile_border">
    <ul class="profile_info">
        <li class="row">
            <div class="profile_info__left">ID</div>
            <div class="profile_info__right"><?php echo $each['id']; ?></div>
        </li>
        <li class="row">
            <div class="profile_info__left">Avatar</div>
            <div class="profile_info__right">
                <img class="img_profile"
                     src="<?php echo file_exists("../basephp/public/img/".$each['avatar']) ? "../public/img/".$each['avatar'] :  DOMAIN_FB_IMG.$each['avatar'] ; ?>" alt="avatar user">
            </div>
        </li>
        <li class="row">
            <div class="profile_info__left">Name</div>
            <div class="profile_info__right"><?php echo $each['name']; ?></div>
        </li>
        <li class="row">
            <div class="profile_info__left">Email</div>
            <div class="profile_info__right"><?php echo $each['email']; ?></div>
        </li>
    </ul>
</div>
<?php } ?>
<?php
include_once("mvc/views/layouts/footer.php");
?>
