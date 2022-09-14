<?php
include_once("mvc/helpers/resetForm.php");
include_once("mvc/views/layouts/header.php");
include_once("mvc/views/layouts/navbar.php");
?>
<div class="notice">
    <p><?php echo $_SESSION['actionSuccessfully'] ?></p>
</div>
<div class="search_box">
    <form action="" method="GET" id="myForm">
        <div class="row">
            <p class="search_box__form">Email</p>
            <input type="text" class="search_box__form search_box__form--input" name="email" value="<?php echo $_GET['email'] ?? ""; ?>">
        </div>
        <div class="row">
            <p class="search_box__form">Name</p>
            <input type="text" class="search_box__form search_box__form--input" name="name" value="<?php echo $_GET['name'] ?? ""; ?>">
        </div>
        <div class="row search_box__btn">
            <input type="submit" name="submit" value="Reset" class="reset-btn search_box__btn__items">
            <input type="submit" name="submit" value="Search" class="search_box__btn__items search_box__btn__items--blue">
        </div>
    </form>
</div>
<div class="data">
    <div class="paginate">
        <a href="#"><i class="arrow left"></i><i class="arrow left"></i>Prev</a>
        <a href="#">1</a>
        <a href="#">Next<i class="arrow right"></i><i class="arrow right"></i></a>
    </div>
    <table width="100%" border="1" cellspacing="0" class="table table-striped">
        <tr class="table-primary">
            <th>
                <span>ID</span>
                <a onclick="sortTable(0)" class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                       <i class="arrow up"></i><i class="arrow down"></i> 
                    <?php } ?>
                </a>
            </th>
            <th class="text-center avatar_column">Avatar</th>
            <th class="text-center">
                <span>Name</span>
                <a onclick="sortTable(1)" class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                        <i class="arrow up"></i><i class="arrow down"></i>
                    <?php } ?>
                </a>
            </th>
            <th class="text-center">
                <span>Email</span>
                <a onclick="sortTable(2)" class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                        <i class="arrow up"></i><i class="arrow down"></i>
                    <?php } ?>
                </a>
            </th>
            <th class="text-center">
                <span>Status</span>
                <a onclick="sortTable(3)" class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                        <i class="arrow up"></i><i class="arrow down"></i>
                    <?php } ?>
                </a>
            </th>
            <th>Action</th>
        </tr>
        <?php
        if ($data["arr"]->rowCount() > 0) {
        ?>
            <?php foreach ($data["arr"] as $each) : ?>
                <tr>
                    <td><?php echo $each['id']; ?></td>
                    <td><img src="<?php echo "../../basephp/public/img/".$each['avatar'] ?>" class="avatar_img" alt="avatar user"></td>
                    <td><?php echo $each['name']; ?></td>
                    <td><?php echo $each['email']; ?></td>
                    <td><?php if ($each['status'] == '1') {
                            echo "Active";
                        } else {
                            echo "Banned";
                        } ?></td>
                    <td><a href="edit/<?php echo  $each['id']; ?>" class="btn btn-edit">Edit</a><a href="delete/<?php echo  $each['id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-del" id="delete">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        <?php } else { ?>
            <tr>
                <td colspan="6" style="text-align:center">No results found!</td>
            </tr>
        <?php }
        ?>
    </table>
</div>
<?php
include_once("mvc/views/layouts/footer.php");
?>