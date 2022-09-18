<?php
$searchData = "";
if(isset($_GET['email'])) {
    $searchData .= "&email=".$_GET['email'];
}

if(isset($_GET['name'])) {
    $searchData .= "&name=".$_GET['name'];
}

if (isset($data['data']) && $data['data']->rowCount() > 0) {
    $totalNumberPages = $data['total_record'][0];
    $numberPages = ceil($totalNumberPages / NUMBER_RECORD_EACH_PAGE);
    $page = $_GET['page'] ?? 1;
    ?>
    <a href="<?php echo "?page=1".$searchData; ?>"><i class="arrow left"></i><i class="arrow left"></i></a>
    <a href="?page=<?php echo ($page - 1) > 0 ? ($page - 1).$searchData : $page.$searchData; ?>">Prev</a>
    <?php


    for ($i = 1; $i <= $numberPages; $i++) {
        ?>
        <a href="?page=<?php echo $i.$searchData; ?>"><?php echo $i; ?></a>
        <?php
    }
    ?>
    <a href="?page=<?php echo ($page + 1) <= $numberPages ? ($page + 1).$searchData : $page.$searchData; ?>">Next</a>
    <a href="?page=<?php echo $numberPages.$searchData ?>"><i class="arrow right"></i><i class="arrow right"></i></a>
    <?php
}
