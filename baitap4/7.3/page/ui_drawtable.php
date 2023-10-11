<?php
//form ve bang

echo '
<form action="index.php?page=drawtable"  method="POST">
<table  align="center">';
echo "
<tr>
<td>tragn draw table</td>
</tr>
<tr>
<td>form ve bang</td>
</tr>
<tr>
<td>so dong : <input type='number' name='dong' /></td>
</tr>
<tr>

<td>so cot : <input type='number' name='cot' /></td>

</tr>
<tr>
<td><input type='reset' class='button' name='reset' value='nhap lai' /></td>
</tr>
<tr>
<td><input type='submit' class='button' name='register' value='ve' /></td>
</tr>

";

echo '</table>
</form>';

$n = 0;
$d = 0;
//lay do dong
if (isset($_POST['dong'])) {
    $n = $_POST['dong'];
}
//lay so cot
if (isset($_POST['cot'])) {
    $d = $_POST['cot'];
}
//ve bang
echo '<table border="1" align="center">';
for ($i = 0; $i < $n; $i++) {
    echo '<tr>';
    for ($j = 0; $j < $d; $j++) {
        echo '<td>';
        echo ($j + $i);
        echo '</td>';
    }
    echo '</tr>';
}
echo '</table>';
?>