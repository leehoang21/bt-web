<?php
//giai thừa của 10
$n = 10;
$giaithua = 1;
for ($i = 1; $i <= $n; $i++) {
    $giaithua = $giaithua * $i;
}
echo "GiaiThua:" . $giaithua . "        <br>";
//diện tích và thể tích của hình cầu bán kính 10
$bankinh = 10;
$dientich = 4 * 3.14 * $bankinh * $bankinh;
$thetich = 4 / 3 * 3.14 * $bankinh * $bankinh * $bankinh;
echo "diện tích : $dientich <br>";
echo "thể tích :" . round($thetich, 2) . " <br>&nbsp;&nbsp;";
//hiển thị dòng chữ hello chuyển động 
echo "
<p>

<button onclick='myMove()'>Click Me</button> 
</p>

<div id ='myAnimation'> hello </div>
<script>
var id = null;
function myMove() {
  var elem = document.getElementById('myAnimation');    
  var pos = 300;
  clearInterval(id);
  //Thực thi một chức năng, sau khi đợi một số mili giây được chỉ định.
  id = setInterval(frame, 10);
  function frame() {
    if (pos == 1000) {
      clearInterval(id);
    } else {
      pos++; 
      elem.style.top = 200 + 'px'; 
      elem.style.left = pos + 'px'; 
    }
  }
}
</script>";


?>