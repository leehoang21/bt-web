<?php
// Tìm Start 
$start = ($current_page - 1) * $limit;
// BƯỚC 5: TRUY VẤN
// LẤY DANH SÁCH TIN TỨC // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
$result = mysqli_query($con, "SELECT * FROM member LIMIT $start, $limit");

echo '<div>';
echo '<table cellpadding="0" cellspacing="0" border="1">';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
    <td> Tên đăng nhập :'
        . $row['username'] . '</td><td>'
        . ' Mật khẩu :'
        . $row['password'] . '</td><td>'
        . ' Email :'
        . $row['email'] . '</td><td>'
        . ' Họ và tên :'
        . $row['fullname'] . '</td><td>'
        . ' Ngày sinh :'
        . $row['birthday'] . '</td><td>'
        . ' Giới tính :'
        . $row['sex'] . '</td><td>'
        . '<a href="form_register.php' .
        '?username=' . $row['username'] .
        '&password=' . $row['password'] .
        '&email=' . $row['email'] .
        '&fullname=' . $row['fullname'] .
        '&birthday=' . $row['birthday'] .
        '&sex=' . $row['sex'] .
        '">Edit</a>' . '</td><td>'
        . '<a href="delete.php?' .
        'username=' . $row['username'] .
        '">Delete</a>'
        . '</td>
        </tr>';
}

echo ' </table>';
echo '</div>';
?>