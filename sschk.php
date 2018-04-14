<?php
  /*======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.21 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : sschk.php                                           |
   | DATA-WRITTEN   : 2002.07.21                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2007.12.11                                          |
   | UPDATE-WRITTEN : 2018.03.18 Upgrade to a newer version.              |
   +======================================================================*/
    $var = "sesLoginID";
    if (isset($_SESSION[$var])) {
        $_SESSION[$var];
    } else {
        session_destroy();
        header("Location:login.php");
        exit();
    }
    $sesLoginID = $_SESSION["sesLoginID"];
    $sesadmin = $_SESSION["sesadmin"];
    $sesjpname = $_SESSION["sesjpname"];
?>
