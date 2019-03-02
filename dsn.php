<?php
/* +======================================================================+
   | PHP version 7.1.16                                                   |
   +----------------------------------------------------------------------+
   | Copyright (C) 2019.03.02 N.watanuki.                                 |
   +----------------------------------------------------------------------+
   | Database Connect Script                                              |
   | Script-ID      : dsn.php                                             |
   | DATA-WRITTEN   : 2018.07.25                                          |
   | AUTHER         : _.________                                          |
   | UPDATE-WRITTEN : ____.__.__                                          |
   |                                                                      |
   | DSN DB接続文字列をiniファイルから読み込む                            |
   | (*データベース接続情報を隠すため)                                    |
   |                                                                      |
   | *注意                                                                |
   |  このSource Codeの[$fp=fopen...]は、Linux用です。Windowsの場合は、   |
   |  下記の[$fp=fopen]のコメントを変更すること                           |
   |  $fp = fopen('/usr/local/apache2/htdocs/gs/config/gscdsn.ini','r');  |
   +======================================================================+ */
    function get_dsn() {
        //$fp = fopen("C:\Apache2\htdocs\gs\config\gscdsn.ini","r");  // for Windows
        $fp = fopen('/usr/local/apache2/htdocs/gs/config/gscdsn.ini','r'); /* for Linux */
        if ( $fp == false ){
            die("dsn設定ファイルが見つかりません！");
        }
        $dsn = trim(fgets($fp,255));
        fclose($fp);
        return $dsn;
    }

    function get_opt() {
        $options = array(
            'debug'       => 2,
            'portability' => DB_PORTABILITY_ALL,
        );
        return $option;
    }
?>
