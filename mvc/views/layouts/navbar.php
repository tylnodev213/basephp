<?php
$controllers = (new App)->getController();
$action = (new App)->getAction();
?>
<body>
    <div class="header_navbar">
        <ul class="row header_navbar__list">
            <li class="header_navbar__list__items">
                <ul class="header_navbar__list__items--menu <?php echo ($controllers=="Admin") ? "active" : ""  ?>">
                    <li class="header_navbar__list__items__menu--hover">Admin management<i class="arrow menu-down"></i></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--first <?php echo ($controllers=="Admin" && $action=="search") ? "active" : ""  ?>"><a href="<?php DOMAIN."Admin/search" ?>">Search</a></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--last <?php echo ($controllers=="Admin" && $action=="create") ? "active" : ""  ?>"><a href="<?php DOMAIN."Admin/create" ?>">Create</a></li>
                </ul>
            </li>
            <li class="header_navbar__list__items">
                <ul class="header_navbar__list__items--menu <?php echo ($controllers=="User") ? "active" : ""  ?>">
                    <li class="header_navbar__list__items__menu--hover">User management<i class="arrow menu-down"></i></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--first <?php echo ($controllers=="User" && $action=="search") ? "active" : ""  ?>"><a href="<?php DOMAIN."Admin/search"?>">Search</a></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--last <?php echo ($controllers=="User" && $action=="create") ? "active" : ""  ?>"><a href="<?php DOMAIN."Admin/create"?>">Create</a></li>
                </ul>
            </li>
            <li class="header_navbar__list__items">
                <p class="header_navbar__list__items__menu--logout"><a href="logout">Logout</a>
                <P>
            </li>
        </ul>
    </div>