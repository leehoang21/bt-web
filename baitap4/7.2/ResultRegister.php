<?php
$name = '';
$address = '';
$caser = '';
$note = '';
if ($_POST["name"] && $_POST["address"] && $_POST["caser"] && $_POST["note"]) {

    $name = $_POST["name"];
    $address = $_POST["address"];
    $caser = $_POST["caser"];
    $note = $_POST["note"];
} else
    print "invaild input data";


echo '<h1 style="color=qua;">ket qua dang ky</h1>    
<h1>ten : ' . $name . '</h1>
<h1>dia chi : ' . $address . '</h1>
<h1>nghe : ' . $caser . '</h1>
<h1>ghi chu : ' . $note . '</h1>  
'


    ?>