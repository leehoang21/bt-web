<?php
//url ?username=&password=&email=&fullname=&birthday=&sex=


//lấy username
$username = isset($_GET['username']) === false ? '' : $_GET['username'];
//lấy password
$password = isset($_GET['password']) === false ? '' : $_GET['password'];
//lấy email
$email = isset($_GET['email']) === false ? '' : $_GET['email'];
//lấy fullname
$fullname = isset($_GET['fullname']) === false ? '' : $_GET['fullname'];
//lấy birthday
$birthday = isset($_GET['birthday']) === false ? '' : $_GET['birthday'];
//lấy sex
$sex = isset($_GET['sex']) === false ? '' : $_GET['sex'];

echo '<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trang đăng lý</title>
</head>

<body>
    <h1>Trang đăng ký thành viên</h1>
    <form action="register.php?isUpdate=' .
    ($username == '' ? 'false' : 'true') .
    '" method="POST">
        <table cellpadding="0" cellspacing="0" border="1">
            <tr>
                <td>
                    Tên đăng nhập :
                </td>
                <td>
                    <input type="text" name="txtUsername" size="50" value=' .
    $username .
    '
                </td>
            </tr>
            <tr>
                <td>
                    Mật khẩu :
                </td>
                <td>
                    <input type="password" name="txtPassword" size="50" value=' .
    $password . '
                </td>
            </tr>
            <tr>
                <td>
                    Email :
                </td>
                <td>
                    <input type="email" name="txtEmail" size="50" value=' .
    $email . '
                </td>
            </tr>
            <tr>
                <td>
                    Họ và tên :
                </td>
                <td>
                    <input type="text" name="txtFullname" size="50" value=' .
    $fullname . '
                </td>
            </tr>
            <tr>
                <td>
                    Ngày sinh :
                </td>
                <td>
                    <input type="text" name="txtBirthday" size="50" value=' . $birthday . '
                </td>
            </tr>
            <tr>
                <td>
                    Giới tính :
                </td>
                <td>
                    <select name="txtSex">
                        <option value=""></option>
                        <option value="Nam"
                        ' . (strtoupper($sex) == 'NAM' ? 'selected' : '') . '
                        >Nam</option>
                        <option value="Nu"
                        ' . (strtoupper($sex) == 'NU' ? 'selected' : '') . '
                        >Nữ</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="'
    .
    ($username == '' ? 'Đăng ký' : 'Cập nhật') .
    '"
        />
        <input type="reset" value="Nhập lại" />
    </form>
</body>

</html>';
?>