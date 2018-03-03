<?php
session_start();
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.08.05 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : weekadd.php                                         |
   | DATA-WRITTEN   : 2002.08.05                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2008.01.21                                          |
   +======================================================================*/
require_once("sschk.php");

    $sCurMonday = day_add($sCurMonday,$days);
    header("Location: wcalen.php");
    
    function day_add($sCurMonday,$dayAdd) {
        $oldDay = getdate($sCurMonday);
        $year = $oldDay["year"];
        $month = $oldDay["mon"];
        $day = $oldDay["mday"] + $dayAdd;
        return (mktime(0,0,0,$month,$day,$year));
    }
?>
