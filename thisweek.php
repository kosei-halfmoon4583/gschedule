<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : thisweek.php                                        |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
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
