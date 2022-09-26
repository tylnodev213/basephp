<?php
include_once("mvc/helpers/resetForm.php");
include_once("mvc/views/layouts/header.php");
include_once("mvc/views/layouts/navbar.php");
include_once("mvc/views/layouts/sort.php");
?>
    <div class="notice">
        <?php echo $message = checkSessionActionSuccessful() ? getSessionActionSuccessful() : "";
        unsetSessionActionSuccessful(); ?>
        <?php echo $message = checkSessionMessage('Data') ? getSessionMessage('Data') : "";
        unsetSessionMessage('Data'); ?>
    </div>
    <div class="search_box">
        <form action="" method="GET" id="myForm">
            <div class="row">
                <p class="search_box__form">Email</p>
                <input type="text" class="search_box__form search_box__form--input" name="email"
                       value="<?php echo $_GET['email'] ?? ""; ?>">
            </div>
            <div class="row">
                <p class="search_box__form">Name</p>
                <input type="text" class="search_box__form search_box__form--input" name="name"
                       value="<?php echo $_GET['name'] ?? ""; ?>">
            </div>
            <div class="row search_box__btn">
                <input type="submit" name="submit" value="Reset" class="reset-btn search_box__btn__items">
                <input type="submit" value="Search" class="search_box__btn__items search_box__btn__items--blue">
            </div>
        </form>
    </div>
    <div class="data">
        <div class="paginate">
            <?php
            include("mvc/views/layouts/pagination.php");
            ?>
        </div>
        <table width="100%" border="1" cellspacing="0" class="table table-striped">
            <tr class="table-primary">
                <th class="text-center">
                    <span>ID</span>
                    <span class="sort">
                    <?php
                    if ($data["data"]->rowCount() > 0) {
                        ?>
                        <a href="<?php sortByField('id', 'ASC'); ?>"><i class="arrow up"></i></a>
                        <a href="<?php sortByField('id', 'DESC'); ?>"><i class="arrow down"></i></a>
                    <?php } ?>
                </span>
                </th>
                <th class="text-center avatar_column">Avatar</th>
                <th class="text-center">
                    <span>Name</span>
                    <span class="sort">
                    <?php
                    if ($data["data"]->rowCount() > 0) {
                        ?>
                        <a href="<?php sortByField('name', 'ASC'); ?>"><i class="arrow up"></i></a>
                        <a href="<?php sortByField('name', 'DESC'); ?>"><i class="arrow down"></i></a>
                    <?php } ?>
                </span>
                </th>
                <th class="text-center">
                    <span>Email</span>
                    <span class="sort">
                    <?php
                    if ($data["data"]->rowCount() > 0) {
                        ?>
                        <a href="<?php sortByField('email', 'ASC'); ?>"><i class="arrow up"></i></a>
                        <a href="<?php sortByField('email', 'DESC'); ?>"><i class="arrow down"></i></a>
                    <?php } ?>
                </span>
                </th>
                <th class="text-center">
                    <span>Role</span>
                    <span class="sort">
                    <?php
                    if ($data["data"]->rowCount() > 0) {
                        ?>
                        <a href="<?php sortByField('role_type', 'ASC'); ?>"><i class="arrow up"></i></a>
                        <a href="<?php sortByField('role_type', 'DESC'); ?>"><i class="arrow down"></i></a>
                    <?php } ?>
                </span>
                </th>
                <th class="text-center">Action</th>
            </tr>
            <?php
            if ($data["data"]->rowCount() > 0) {
                ?>
                <?php foreach ($data["data"] as $each) : ?>
                    <tr>
                        <td class="column text-center"><?php echo $each['id']; ?></td>
                        <td class="column text-center"><img
                                    src="<?php echo "../../basephp/public/img/".$each['avatar'] ?>" class="avatar_img"
                                    alt="avatar admin"></td>
                        <td class="column"><?php echo $each['name']; ?></td>
                        <td class="column"><?php echo $each['email']; ?></td>
                        <td class="column"><?php if ($each['role_type'] == '1') {
                                echo "Super Admin";
                            } else {
                                echo "Admin";
                            } ?></td>
                        <td class="column text-center"><a href="edit/<?php echo $each['id']; ?>" class="btn btn-edit">Edit</a><a
                                    href="delete/<?php echo $each['id']; ?>" onclick="return confirm('Are you sure?')"
                                    class="btn btn-del" id="delete">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" style="text-align:center"><?php echo DATA_NOT_FOUND ?></td>
                </tr>
            <?php }
            ?>
        </table>
    </div>
<?php
include_once("mvc/views/layouts/footer.php");
?>