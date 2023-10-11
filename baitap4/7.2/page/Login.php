<?php
echo "
<html>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <link rel='stylesheet' href='style.css' />
</head>

<body>
    <form action='login.php' class='dangnhap' method='POST'>
        <h2>Login Form</h2>
        username : <input type='text' name='username' />
        <br />
        <br />
        password : <input type='password' name='password' />
        <br />
        <br />
        <input type='reset' class='button' name='reset' value='reset' />
        <input type='submit' class='button' name='dangnhap' value='login' />
        <!-- <a href='dangky.php' title='Đăng ký'>Đăng ký</a> -->
        <!-- <?php require 'xuly.php'; ?> -->
        <form>
</body>

</html>"
    ?>