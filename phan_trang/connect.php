<?php
$ketnoi['host'] = 'localhost'; //Tên server, nếu dùng hosting free thì cần thay đổi
$ketnoi['dbname'] = 'phan_trang'; //Đây là tên của Database
$ketnoi['username'] = 'root'; //Tên sử dụng Database
$ketnoi['password'] = ''; //Mật khẩu của tên sử dụng Database
$con = mysqli_connect($ketnoi['host'], $ketnoi['username'], $ketnoi['password']);
mysqli_select_db($con, $ketnoi['dbname']);