<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

} else {
    $page = 'home';
}

echo '<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';

echo '
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    ';
include 'page/head.php';
'
</head>';

echo '
<body>
    <div class="container">
        <div class="avatar">
        ';
include 'page/left.php';
'    
        </div>
        <div >
        ';
switch ($page) {
    case 'contact':
        include 'page/ui_caculate.php';
        break;
    case 'drawtable':
        include 'drawtable.php';
        break;
    case 'loop':
        include 'loop.php';
        break;
    default:
        include 'page/center.php';
        break;
}

'    
        </div>
       
        
    </div>
</body>';

echo '<div class="skills">
        
';

include 'page/footer.php';
'

</div>';


?>