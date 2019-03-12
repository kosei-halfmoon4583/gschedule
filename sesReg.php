<?php
  /*======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2018.07.25 _.________                                  |
   +----------------------------------------------------------------------+
   | Script-ID      : sesReg.php                                          |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : 2019.03.12                                          |
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
