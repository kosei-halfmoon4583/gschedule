<?php
    /*==========================================================================+
     | PHP version 7.1.16                                                       |
     +--------------------------------------------------------------------------+
     | Copyright (C) 2014.05.30 N.watanuki                                      |
     +--------------------------------------------------------------------------+
     | Script-ID      : getHotelP.php                                           |
     | DATA-WRITTEN   : 2014.05.30                                              |
     | AUTHER         : N.WATANUKI                                              |
     | UPDATE-WRITTEN : 2019.03.12                                              |
     +==========================================================================*/
    header("Content-Type: text/xml");
    $handle = @readfile("http://jws.jalan.net/APIAdvance/HotelSearch/V1/?key=peg114fd81bc17&s_area=".($_GET["s_area"]));
?>
