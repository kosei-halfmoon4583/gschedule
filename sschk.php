<?php
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : sschk.php                                           |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
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
