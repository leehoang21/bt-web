<?php
for ($i = 0; $i < 20; $i++) {
    for ($j = (20 - $i); $j < 20; $j++) {
        echo "*";
    }
    echo "<br>";
}
?>


<?php
$i = 0;
while ($i < 20) {
    $j = (20 - $i);
    while ($j < 20) {
        echo "*";
        $j++;
    }
    $i++;
    echo "<br>";
}
?>

<?php
$i = 0;
do {
    echo "<br>";
    $j = (20 - $i);
    do {
        echo "*";
        $j++;
    } while ($j < 20);
    $i++;
} while ($i < 20);
?>