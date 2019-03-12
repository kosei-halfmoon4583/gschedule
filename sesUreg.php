<?php
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright(C). 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Session Unregister Class                                             |
   | Script-ID      : sesUreg.php                                         |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
if (isset($_SESSION["sschd"])) {
    unset($_SESSION["sschd"]);
}
if (isset($_SESSION["oldschd"])) {
    unset($_SESSION["oldschd"]);
}
if (isset($_SESSION["ssid"])) {
    unset($_SESSION["ssid"]);
}
?>
