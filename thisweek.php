<?php
session_start();
  /*======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2008.01.21 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : thisweek.php                                        |
   | DATA-WRITTEN   : 2008.01.21                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2018.03.08 Upgrade to a newer version.              |
   +======================================================================*/
    require_once("sschk.php");
     
    if (isset($_GET["days"])) {
        $days = $_GET["days"];
    }
 
    $_SESSION["thisMonday"] = day_add($_SESSION["thisMonday"],$days);
    $_SESSION["flag"] = 1;
    header("Location: wcalen.php");

    function day_add($thisMonday,$dayAdd) {
        $defaultDay = getdate($thisMonday);
        $year = $defaultDay["year"];
        $month = $defaultDay["mon"];
        $day = $defaultDay["mday"] + $dayAdd;
        return (mktime(0,0,0,$month,$day,$year));
    }
?>
