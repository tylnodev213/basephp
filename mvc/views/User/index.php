<?php
include_once("mvc/views/layouts/header.php");
include_once("mvc/views/layouts/navbar.php");
?>
<div class="notice">
    <p>Create successful</p>
</div>
<div class="search_box">
    <form action="search" method="GET" id="myForm">
        <div class="row">
            <p class="search_box__form">Email</p>
            <input type="text" class="search_box__form search_box__form--input" name="email">
        </div>
        <div class="row">
            <p class="search_box__form">Name</p>
            <input type="text" class="search_box__form search_box__form--input" name="name">
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
            <th class="text-center">
                <span>ID</span>
                <span class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                        <i class="arrow up"></i><i class="arrow down"></i>
                    <?php } ?>
                </span>
            </th>
            <th class="text-center avatar_column">Avatar</th>
            <th class="text-center">
                <span>Name</span>
                <span class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                        <i class="arrow up"></i><i class="arrow down"></i>
                    <?php } ?>
                </span>
            </th>
            <th class="text-center">
                <span>Email</span>
                <span class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                        <i class="arrow up"></i><i class="arrow down"></i>
                    <?php } ?>
                </span>
            </th>
            <th class="text-center">
                <span>Status</span>
                <span class="sort">
                    <?php
                    if ($data["arr"]->rowCount() > 0) {
                    ?>
                        <i class="arrow up"></i><i class="arrow down"></i>
                    <?php } ?>
                </span>
            </th>
            <th class="text-center">Action</th>
        </tr>
        <?php
        if ($data["arr"]->rowCount() > 0) {
        ?>
            <?php foreach ($data["arr"] as $each) : ?>
                <tr>
                    <td class="column text-center"><?php echo $each['id']; ?></td>
                    <td class="column text-center"><img src="<?php echo "../../basephp/public/img/".$each['avatar'] ?>" class="avatar_img" alt="avatar admin"></td>
                    <td class="column"><?php echo $each['name']; ?></td>
                    <td class="column"><?php echo $each['email']; ?></td>
                    <td class="column"><?php if ($each['status'] == '1') {
                            echo "Active";
                        } else {
                            echo "Banned";
                        } ?></td>
                    <td class="column text-center"><a href="edit/<?php echo  $each['id']; ?>" class="btn btn-edit">Edit</a><a href="delete/<?php echo  $each['id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-del" id="delete">Delete</a></td>
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