<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body>
    <?php
    if (isset($_SESSION['username']) && $_SESSION['username']) {
        include('index.php');
    } else {
        echo 'Bạn chưa đăng nhập';
    }
    ?>
</body>

</html>