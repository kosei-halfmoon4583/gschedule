<?php
session_start();
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2008.01.21 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : thisweek.php                                        |
   | DATA-WRITTEN   : 2008.01.21                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   +======================================================================*/
require_once("sschk.php");
$thisMonday = day_add($thisMonday,$days);
header("Location: wcalen.php");
$flag = 1;
function day_add($thisMonday,$dayAdd) {
    $defaultDay = getdate($thisMonday);
    $year = $defaultDay["year"];
    $month = $defaultDay["mon"];
    $day = $defaultDay["mday"] + $dayAdd;
    //$flag = 1;
    return (mktime(0,0,0,$month,$day,$year));
}
?>
