<?php
session_start();
  /*======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.08.05 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : weekadd.php                                         |
   | DATA-WRITTEN   : 2002.08.05                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2008.01.21                                          |
   | UPDATE-WRITTEN : 2018.03.08 Upgrade to a newer version.              |
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
