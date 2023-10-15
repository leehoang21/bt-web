<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

} else {
    $page = 'home';
}

include 'top.php';
switch ($page) {

    case 'drawtable':
        include 'drawtable.php';
        break;
    case 'loop':
        include 'loop.php';
        break;
    default:
        include 'page/center.php';
        break;
}
include 'bottom.php';
?>