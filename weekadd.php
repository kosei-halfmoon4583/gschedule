<?php
session_start();
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : weekadd.php                                         |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
   +======================================================================*/
    require_once("sschk.php");

    if (isset($_GET["days"])) {
        $days = $_GET["days"];
    }

    $_SESSION["sCurMonday"] = day_add($_SESSION["sCurMonday"],$days);
    header("Location: wcalen.php");
    
    function day_add($sCurMonday,$dayAdd) {
        $oldDay = getdate($sCurMonday);
        $year = $oldDay["year"];
        $month = $oldDay["mon"];
        $day = $oldDay["mday"] + $dayAdd;
        return (mktime(0,0,0,$month,$day,$year));
    }
?>
