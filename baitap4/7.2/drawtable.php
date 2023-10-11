<?php
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
        <div class="name">
        ';
include 'page/ui_drawtable.php';

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