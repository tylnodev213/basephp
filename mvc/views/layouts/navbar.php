<?php
$url = explode('/',$_SERVER['REQUEST_URI']);
$controllers = $url[2];
$action = str_replace(strchr($url[3], "?"), "", $url[3]);
?>
<body>
    <div class="header_navbar">
        <ul class="row header_navbar__list">
            <li class="header_navbar__list__items">
                <ul class="header_navbar__list__items--menu <?php echo ($controllers=="Admin") ? "active" : "" ;?>">
                    <li class="header_navbar__list__items__menu--hover"><a href="<?php  echo DOMAIN."Admin/index";?>">Admin management</a><i class="arrow menu-down"></i></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--first <?php echo ($controllers=="Admin" && $action=="search") ? "active" : "";  ?>"><a href="<?php echo  DOMAIN."Admin/search" ?>">Search</a></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--last <?php echo ($controllers=="Admin" && $action=="create") ? "active" : "";  ?>"><a href="<?php echo  DOMAIN."Admin/create" ?>">Create</a></li>
                </ul>
            </li>
            <li class="header_navbar__list__items">
                <ul class="header_navbar__list__items--menu <?php echo ($controllers=="User") ? "active" : ""  ?>">
                    <li class="header_navbar__list__items__menu--hover"><a href="<?php  echo DOMAIN."User/index";?>">User management</a><i class="arrow menu-down"></i></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--first <?php echo ($controllers=="User" && $action=="search") ? "active" : "";  ?>"><a href="<?php  echo DOMAIN."User/search"?>">Search</a></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--last <?php echo ($controllers=="User" && $action=="create") ? "active" : "";  ?>"><a href="<?php  echo DOMAIN."User/create"?>">Create</a></li>
                </ul>
            </li>
            <li class="header_navbar__list__items">
                <p class="header_navbar__list__items__menu--logout"><a href="logout">Logout</a>
                <P>
            </li>
        </ul>
    </div>