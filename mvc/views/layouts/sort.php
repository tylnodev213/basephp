<?php
function sortByField($sortField,$sortDirection)
{
    $sort = "?sortField=".$sortField."&sortDirection=".$sortDirection;

    if(isset($_GET['email'])) {
        $sort.= "&email=".$_GET['email'];
    }

    if(isset($_GET['name'])) {
        $sort.= "&name=".$_GET['name'];
    }

    if(isset($_GET['page'])) {
        $sort.= "&page=".$_GET['page'];
    }

    echo $sort;
}
?>