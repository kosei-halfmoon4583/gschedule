<?php
  /*======================================================================+
   | PHP version 4.4.2                                                    |
   +----------------------------------------------------------------------+
   | Copyright (C) 2002.07.29 N.watanuki                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : sesReg.php                                          |
   | DATA-WRITTEN   : 2002.07.29                                          |
   | AUTHER         : N.WATANUKI                                          |
   | UPDATE-WRITTEN : 2008.01.24                                          |
   +======================================================================*/
    function sesReg_sRet() {
        if (!isset($_SESSION["sRet"])) {
            $_SESSION["sRet"] = array();
        }
    }
    function sesReg_sschd() {
        if (!isset($_SESSION["sschd"])) {
            $_SESSION["sschd"] = array();
        }
    }
    function sesReg_sUsr() {
        if (!isset($_SESSION["usrEnt"])) {
            $_SESSION["usrEnt"] = array();
        }
    }
?>
