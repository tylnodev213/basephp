<?php
if (isset($data['data']) && $data['data']->rowCount() > 0) {
    $totalNumberPages = $data['total_record'][0];
    $numberPages = ceil($totalNumberPages / NUMBER_RECORD_EACH_PAGE);
    $page = $_GET['page'] ?? 1;
    ?>
    <a href="?page=1"><i class="arrow left"></i><i class="arrow left"></i></a>
    <a href="?page=<?php echo ($page - 1) > 0 ? $page - 1 : $page; ?>">Prev</a>
    <?php
    for ($i = 1; $i <= $numberPages; $i++) {
        ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php
    }
    ?>
    <a href="?page=<?php echo ($page + 1) <= $numberPages ? $page + 1 : $page; ?>">Next</a>
    <a href="?page=<?php echo $numberPages ?>"><i class="arrow right"></i><i class="arrow right"></i></a>
    <?php
}
