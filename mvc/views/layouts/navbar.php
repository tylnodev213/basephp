<body>
    <div class="header_navbar">
        <ul class="row header_navbar__list">
            <li class="header_navbar__list__items">
                <ul class="header_navbar__list__items--menu <?php echo ($controller=="Admin") ? "active" : "" ;?>">
                    <li class="header_navbar__list__items__menu--hover"><a href="<?php  echo DOMAIN."Admin/search";?>">Admin management</a><i class="arrow menu-down"></i></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--first <?php echo ($controller=="Admin" && $action=="search") ? "active" : "";  ?>"><a href="<?php echo  DOMAIN."Admin/search" ?>">Search</a></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--last <?php echo ($controller=="Admin" && $action=="create") ? "active" : "";  ?>"><a href="<?php echo  DOMAIN."Admin/create" ?>">Create</a></li>
                </ul>
            </li>
            <li class="header_navbar__list__items">
                <ul class="header_navbar__list__items--menu <?php echo ($controller=="User") ? "active" : ""  ?>">
                    <li class="header_navbar__list__items__menu--hover"><a href="<?php  echo DOMAIN."User/search";?>">User management</a><i class="arrow menu-down"></i></li>
                    <li class="header_navbar__list__items__menu header_navbar__list__items__menu--first <?php echo ($controller=="User" && $action=="search") ? "active" : "";  ?>"><a href="<?php  echo DOMAIN."User/search"?>">Search</a></li>
                </ul>
            </li>
            <li class="header_navbar__list__items">
                <p class="header_navbar__list__items__menu--logout"><a href="logout">Logout</a>
                <P>
            </li>
        </ul>
    </div>