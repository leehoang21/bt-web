<?php
$n = 9;
$d = 4;
//Tam giac vuông đơn giản
for ($i = 0; $i < $d; $i++) {
    for ($j = 0; $j < $n; $j++) {
        echo ($j + $i);
        echo '&nbsp;&nbsp;';
    }
    echo "<br>";
}
?>