<?php
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright(C). 2008.01.22 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Session Unregister Class                                             |
   | Script-ID      : sesUreg.php                                         |
   | DATA-WRITTEN   : 2002.08.07                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2008.01.22                                          |
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
