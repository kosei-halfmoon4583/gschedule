<?php
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.21 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : sschk.php                                           |
   | DATA-WRITTEN   : 2002.07.21                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2007.12.11                                          |
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
