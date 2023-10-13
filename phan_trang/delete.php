<?php

//lấy username
$username = isset($_GET['username']) === false ? '' : $_GET['username'];
// KẾT NỐI CSDL
include('connect.php');
//xoá username
if ($username != '') {
    $sql = "DELETE FROM member WHERE username='$username'";
    mysqli_query($con, $sql);
}
header('Location: home.php');
?>