<?php
session_start();
/* +======================================================================+
   | PHP version 5.6.30                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.16 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : lout.php                                            |
   | DATA-WRITTEN   : 2002.07.16                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2018.03.02 Upgrade to a newer version.              |
   +======================================================================+ */
    require_once("sschk.php");
    session_destroy();
    header("Location: login.php");
?>
