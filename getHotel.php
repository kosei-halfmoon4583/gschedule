<?php
header("Content-Type: text/xml");
$handle = @readfile("http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=peg114fd81bc17&s_area=".($_GET["s_area"]));
/*$handle = @readfile("http://jws.jalan.net/APICommon/AreaSearch/V1/?key=peg114fd81bc17&s_area=".($_GET["s_area"])); */
?>
